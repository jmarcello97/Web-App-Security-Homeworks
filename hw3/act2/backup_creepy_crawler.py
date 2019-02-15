from bs4 import BeautifulSoup
from user_agent import *
from multiprocessing import Lock,Process,Pool

DEPTH=3

class Link(object):
	link=""
	parent=""
	depth=0

	
def creepy_crawl(host,lock):
	request_type="GET"
	#file_path="/"
	file_path="http://10.0.0.51"
	port=80
	connection="close"
	parameters=None

	response = request(request_type,file_path,host,port,connection,parameters)
	print(response)
	soup=BeautifulSoup(response, 'html.parser')

	count=0

	stack=[]
	total=[]
	for link in soup.find_all('a', href=True):
		count+=1
		stack.append((link['href'],1))
		total.append(link['href'])
		#print(link['href'])

	print(count)

	total_emails=[]

	path=("http://10.0.0.51",1)

	while(len(stack) != 0):
		print(stack)
		prev=path
		parent=stack.pop(0)

		if prev[1] > parent[1]:
			lst=prev[0].split("/")
			for i in range(parent[1]-1):
				 
		#print(parent)
		if parent[1] != DEPTH and len(parent[0]) > 1:
			if host in parent[0] or "http" not in parent[0] or "https" not in parent[0]:
				
				#lock.acquire()

				print(parent[0])
				if "http" not in parent[0] and "https" not in parent[0]:
					if parent[0][0] != "/":
						path=(prev[0]+"/"+parent[0]+"/",prev[1]+1)
					else:
						path=(prev[0]+parent[0],prev[1]+1)
					#port=443
				elif "https" in parent[0]:
					path=parent[0]
					port=443
				else:
					path=parent[0]
					port=80

				#print(path)
				response=request(request_type,path,host,port,connection,parameters)
				print(response)
				soup=BeautifulSoup(response, 'html.parser')

				emails=soup.select("a[href^=mailto]")
			
				for email in emails:
					total_emails.append(email['href'])


				#emails=[email["href"] for email in soup.select("a[href^=malito:]")]
				#all_emails+=emails
				#print(total_emails)
				#print(len(total_emails))
				#print(parent)
				print(response)
				
				#exit(0)
				#lock.release()
				for link in soup.find_all('a', href=True):
					print(link['href'])
					stack.insert(0,(link['href'],parent[1]+1))
					total.append(link['href'])
				#print(total)

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
	#	p = Process(target=creepy_crawl, args=("www.rit.edu",lock))
	#	p.start()

	creepy_crawl("10.0.0.51",lock)


main()
