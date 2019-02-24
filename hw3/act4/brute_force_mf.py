from user_agent import *
from bs4 import BeautifulSoup

def main():
	f = open("paths.txt", "r")
	
	request_type="GET"
	host="csec380-core.csec.rit.edu"
	port=83
	connection="close"
	parameters=None

	found=[]

	for file_path in f:
		file_path=file_path.strip()
		response=request(request_type, "/"+file_path, host, port, connection, parameters)
		#print(response)
		if response != 1:
			print("FOUND=> {}/{}".format(host,file_path))
			found.append(file_path)

	f2 = open("found_directories.txt", "w+")

	for f in found:
		f2.write(f+"\n")

	f.close()
	f2.close()

if __name__=="__main__":
	main()	
