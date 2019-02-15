from bs4 import BeautifulSoup
from user_agent import *
from multiprocessing import Lock,Process,Pool

DEPTH=4

class Link(object):
	link=""
	parent=""
	depth=0

	def __init__(self,link,parent,depth):
		self.link=link
		self.parent=parent
		self.depth=depth

def make_link(link,parent,depth):
	new_link = Link(link,parent,depth)
	return new_link

def print_link_attributes(link):
	print("Link: {}".format(link.link.encode('utf-8')))
	print("Parent: {}".format(link.parent.encode('utf-8')))
	print("Depth: {}".format(link.depth))
	
def creepy_crawl(host):
	request_type="GET"
	file_path="https://www.rit.edu"
	port=443
	#file_path="http://10.0.0.51"
	#port=80
	connection="close"
	parameters=None

	response = request(request_type,file_path,host,port,connection,parameters)
	print(response)
	soup=BeautifulSoup(response, 'html.parser')

	count=0

	stack=[]
	total=[]
	for l in soup.find_all('a', href=True):
		count+=1
		link=make_link(l['href'],file_path,1)
		stack.append(link)
		total.append(link)
		#print(link['href'])

	print(count)

	total_emails=[]


	visited=[]
	errors=[]

	while(len(stack) != 0):
		print(stack)
		parent=stack.pop(0)

		#if prev[1] > parent[1]:
		#	lst=prev[0].split("/")
		#	for i in range(parent[1]-1):
				 
		#print(parent)
		print(parent.link)
		print(parent.depth)
		if parent.depth != DEPTH and len(parent.link) > 1:
			if "rit.edu" in parent.link or "http" not in parent.link or "https" not in parent.link:
				#lock.acquire()

				print(parent.link)
				if "http" not in parent.link and "https" not in parent.link:
					if parent.link[0] != "/" and parent.parent[-1] != "/":
						path=(parent.parent+"/"+parent.link)
					else:
						path=(parent.parent+parent.link)
					if parent.link[-1] != "/":
						path+="/"
					#port=443
				elif "https" in parent.link:
					path=parent.link
					port=443
				else:
					path=parent.link
					port=80

				#print(path)
				if path not in visited:
					#lock.acquire()
					response=request(request_type,path,host,port,connection,parameters)
					print(response)
					soup=BeautifulSoup(response, 'html.parser')

					emails=soup.select("a[href^=mailto]")
			
					#lock.acquire()
					for email in emails:
						if email['href'] not in total_emails:
							total_emails.append(email['href'])
	
					visited.append(path)


					#emails=[email["href"] for email in soup.select("a[href^=malito:]")]
					#all_emails+=emails
					#print(total_emails)
					#print(len(total_emails))
					#print(parent)
					print(response)
				
					#exit(0)
					#lock.release()
					for l in soup.find_all('a', href=True):
						print(l['href'])
						link=make_link(l['href'],path,parent.depth+1)
						stack.insert(0,link)
						total.append(link)
					#print(total)
					#exit(0)
					#lock.release()

			else:
				errors.append(parent.link)
		

	for link in total:
		print_link_attributes(link)
		print("\n")
	print(len(total))

	for e in errors:
		print(e)

	for email in total_emails:
		print(email)

def main():
	#host="www.rit.edu"
	#request_type="GET"
	#file_path="https://www.rit.edu/overview/finest-facilities"
	#port=443
	#connection="close"
	#parameters=None

        #response = request(request_type,file_path,host,port,connection,parameters)
	#print(response)
	lock = Lock()
	#for i in range(5):
	#	p = Process(target=creepy_crawl, args=("10.0.0.51",lock))
	#	p.start()

	creepy_crawl("www.rit.edu")#,lock)


main()
