from bs4 import BeautifulSoup
from user_agent import *
from multiprocessing import Queue,Lock,Process,Pool,Manager
import os
from urlparse import urlparse
from functools import partial

DEPTH=4
host=""
manager=Manager()
total=[]
visited=manager.list()
paths=manager.list()
port=443
lock = Lock()

f = open("links.txt", "w+")

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
	print("Link: {}".format(link.link.encode))
	print("Parent: {}".format(link.parent))
	print("Depth: {}".format(link.depth))
	


def creepy_crawl(parent):
	#global visited
	h=host
	#print(parent)
	if  parent.depth > DEPTH:
		return None

		
	if parent.depth <= DEPTH and len(parent.link) > 1:

		
		if "http" not in parent.link and "https" not in parent.link:
			try:
				if parent.link[0] != "/" and parent.parent[-1] != "/":
					path=(parent.parent+"/"+parent.link)
				elif parent.link[0] == "/" and parent.parent[-1] == "/":
					parent.link=parent.link.split("/")[1]
					path=parent.parent+parent.link
				else:
					path=(parent.parent+parent.link)
				global port
				p=port

			except:
				return None
			
		elif "https" in parent.link:

			data=urlparse(parent.link)
			h=data.netloc
			path=data.path

			p=443
		else:

			data=urlparse(parent.link)

			h=data.netloc
			path=data.path
			#print(path)

			p=80


		
		if len(host.split("www.")) < 2:
			return None

		lock.acquire()
		if (h+path) not in visited and host.split("www.")[1] in h and "pdf" not in path and "png" not in path and "jpg" not in path:
			f.write(path+"\n")
			response=request("GET",path,h,p,"close",None)
			#lock.acquire()
			visited.append(h+path)
			lock.release()
			if response != 1:
				print('VISITED=>{} {}'.format(h+path,parent.depth))
				soup=BeautifulSoup(response, 'html.parser', from_encoding="iso-8859-1")
		
				try:
					if parent.depth != DEPTH:
						for l in soup.find_all('a', href=True):
							if "mailto" not in l['href']:
								if l['href'] not in visited and h+l['href'] not in visited:
									link=make_link(l['href'],path,parent.depth+1)
 									f.flush()
 									total.append(link)
									creepy_crawl(link)
		

				except:
					return None

		else:
			lock.release()

def path_generator():
	links = open("links.txt", "r")
	paths = open("paths.txt", "w+")

	repeat=[]

	for line in links:
 		lst = line.split("/")
 
 		for item in lst:
 			item=item.strip()
 			if "?" in item:
 				item=item.split("?")[0]
 			if item != "" and item not in repeat:
 				paths.write(item+"/\n")
				repeat.append(item)

	links.close()
	paths.close()

	return 1

def main():

	companies=[]
	f2 = open("companies.csv","r")
	for line in f2:
		line=line.split(",")
		companies.append((line[0],line[1]))

	f2.close()

	domains_visited=1
	company_num=0

	while domains_visited != 25:
		global host
		global port
		request_type="GET"
		file_path="/"
		connection="close"
		parameters=None
		host=companies[company_num][1].strip()
		#file_path=host

		#print(host)
		if "https" in companies[company_num][1]:
			port=443
		else:
			port=80

		data=urlparse(host)
 		host=data.netloc
 		#print(port)
		response = request(request_type,file_path,host,port,connection,parameters)
		
		if response == 1:
			port=443
			response=request(request_type,file_path,host,port,connection,parameters)

		if response != 1:
			print("VISITING {}".format(companies[company_num][0]))
			soup=BeautifulSoup(response, 'html.parser')

			#visited.append(companies[company_num][1].strip())

        		stack=[]
			for l in soup.find_all('a', href=True):
				#print(l['href'])
				link=make_link(l['href'],"/",1)
				stack.append(link)
				#visited.append(link)
				total.append(link)
				path=l['href']
				if "http" in l['href'] or "https" in l['href']:
					path=urlparse(l['href']).path
				if path not in visited:
					f.write(path+"\n")
					visited.append(path)
				#f.write(l['href']+"\n")
					f.flush()



			if len(stack) != 0 and len(stack) < 100 and "autonation" not in host and "pmi.com" not in host and "qualcomm.com" not in host:
				p = Pool(processes=10)
        			p.map(creepy_crawl, stack)
				p.close()
				p.join()

			domains_visited+=1
		company_num+=1
		print(domains_visited)

	f.close()
	path_generator()


if __name__=="__main__":
	main()
