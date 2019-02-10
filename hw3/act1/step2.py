
from user_agent import *
from bs4 import BeautifulSoup
import os

def download_image(lst):
	request_type = "GET"
	host = "www.rit.edu"
	port = 443
	connection = "keep-alive"
	parameters = None

	os.mkdir("./Pictures")

	#file_path = 
	
	for pic in lst:
		file_path = "https://www.rit.edu{}".format(pic).replace(" ", "%20")
		response = request(request_type,file_path,host,port,connection,parameters)
		response = response.split("\r\n\r\n")[1]
		name=pic.split('/')
		name=name[len(name)-1]
	
		file = "./Pictures/{}".format(name)
		with open(file, 'wb') as f:
			f.write(response)
		f.close()

		#print(response)
		#print(name)

def main():
	lst=[]
	request_type = "GET"
        file_path = "https://www.rit.edu/gccis/computingsecurity/people"
        host = "www.rit.edu"
        port = 443
        connection = "close"
        parameters = None

        response = request(request_type,file_path,host,port,connection,parameters)

	#print(response)

	soup = BeautifulSoup(response, 'html.parser')

        #print(soup)

        rows = soup.find_all("div", {"class": "staff-picture"})

	#print(rows)
	
	for r in rows:
		pic = r.find_all("img")[0]["src"]
		lst.append(pic)
		print(pic)

	download_image(lst)
main()
