from bs4 import BeautifulSoup
from user_agent import *
from multiprocessing import Lock,Process,Pool,Manager
import os
from urlparse import urlparse

DEPTH=4
#host="www.rit.edu"
manager=Manager()
total_emails=manager.list()
total=[]
#visited=[]
visited=manager.list()
errors=[]
failed=[]

lock = Lock()
files=[]
for i in range(1, DEPTH+1):
	files.append(open("depth{}_emails.txt".format(i), "w+"))


class Link(object):
	link=""
	parent=""
	depth=0

	def __init__(self,link,parent,depth):
		self.link=link.encode('utf-8')
		self.parent=parent.encode('utf-8')
		self.depth=depth

def make_link(link,parent,depth):
	new_link = Link(link,parent,depth)
	return new_link

def print_link_attributes(link):
	print("Link: {}".format(link.link.encode('utf-8')))
	print("Parent: {}".format(link.parent.encode('utf-8')))
	print("Depth: {}".format(link.depth))
	
def creepy_crawl(parent):

	host="www.rit.edu"
	#print(stack)
	if  parent.depth > DEPTH:
		return 0


	if parent.depth <= DEPTH and len(parent.link) > 1:
		#lock.acquire()

		#print(parent.link)
		if "http" not in parent.link and "https" not in parent.link:
			if parent.link[0] != "/" and parent.parent[-1] != "/":
				path=(parent.parent+"/"+parent.link)
			elif parent.link[0] == "/" and parent.parent[-1] == "/":
				parent.link=parent.link.split("/")[1]
				path=parent.parent+parent.link
			else:
				path=(parent.parent+parent.link)
			port=443
		elif "https" in parent.link:

			data=urlparse(parent.link)
			host=data.netloc
			path=data.path

			port=443
		else:

			data=urlparse(parent.link)

			host=data.netloc
			path=data.path

			port=80

		if (host+path+str(parent.depth)) not in visited and "rit.edu" in host and "pdf" not in path and "png" not in path and "jpg" not in path:
			response=request("GET",path,host,port,"close",None)
		
			visited.append(host+path+str(parent.depth))

			if response == 1 and len(path) > 1:
				#print(path)
				if path[-1] == "/":
 					path=path[:-1]
 				else:
 					path+="/"
 				response=request("GET",path,host,port,"close",None)

				visited.append(host+path+str(parent.depth))

			if response != 1:
				print('VISITED=>{} {}'.format(host+path,parent.depth))
				r=response.split("\r\n\r\n")
				#if "200" not in (r[0]):
				#	visited.append(host+path)
				#	#failed.append(parent)
				#	if path[-1] == "/":
				#		path=path[:-1]
				#	else:
				#		path+="/"
				#	response=request(request_type,path,host,port,connection,parameters)
				#	r=response.split("\r\n\r\n")
				#	if "200" not in r[0]:
				#		failed.append(parent)

				soup=BeautifulSoup(response, 'html.parser', from_encoding="iso-8859-1")

				
				emails=soup.select("a[href^=mailto]")
		
				#lock.acquire()
				#print("Here 1")	
				for email in emails:
					write_to_file=email['href'].split("mailto:")[1].encode('utf-8').strip()
					write_to_file=write_to_file.split("?")[0]
					if write_to_file not in total_emails and "@" in write_to_file and write_to_file != '<a href="':
						files[parent.depth-1].write(write_to_file + "\n")
						files[parent.depth-1].flush()
						#print("HERE 3")
						total_emails.append(write_to_file)
						print("EMAIL=>{} {}".format(write_to_file,parent.depth))
	
				#visited.append(host+path)


				#emails=[email["href"] for email in soup.select("a[href^=malito:]")]
				#all_emails+=emails
				
				#lock.release()
				#print("HERE 4")
				if parent.depth != DEPTH:
					for l in soup.find_all('a', href=True):
						if "mailto" not in l['href']:
							link=make_link(l['href'],path,parent.depth+1)
							total.append(link)
							creepy_crawl(link)
				#exit(0)
				#lock.release()
			else:
				errors.append(parent)



	#creepy_crawl(stack)
	#for link in total:
	#	print_link_attributes(link)
	#	print("\n")
	#print(len(total))

	#print("ERRORS #############################################")
	#for e in errors:
	#	print(e)

	#for email in total_emails:
	#	print(email)

	#print("VISITED #####################################")
	#for l in visited:
	#	print(l)

	#print("FAILED ###################")
	#for f in failed:
	#	print_link_attributes(f)

def main():

	request_type="GET"
	file_path="/"
	port=443
	connection="close"
	parameters=None
	host="www.rit.edu"
	
	response = request(request_type,file_path,host,port,connection,parameters)
	soup=BeautifulSoup(response, 'html.parser')

	visited.append("www.rit.edu/1")

        stack=[]
	for l in soup.find_all('a', href=True):
		link=make_link(l['href'],"/",1)
		stack.append(link)
		total.append(link)
		#print(link['href'])

	print(len(stack))
	emails=soup.select("a[href^=mailto]")


	for email in emails:
		write_to_file=email['href'].split("mailto:")[1].encode('utf-8').strip()
		write_to_file=write_to_file.split("?")[0]

		if write_to_file not in total_emails and "@" in write_to_file:
			files[0].write(write_to_file+"\n")
			total_emails.append(write_to_file)
			print("EMAIL=>{} {}".format(write_to_file,1))

	
	p = Pool(processes=20)
        p.map(creepy_crawl, stack)
	p.close()
	p.join()	
	for f in files:
		f.close()


	print(len(total_emails))

main()
