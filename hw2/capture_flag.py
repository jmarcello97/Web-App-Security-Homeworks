#!/usr/bin/python2.7

from user_agent import *

PORT=82
HOST="csec380-core.csec.rit.edu"

def get_token():
	file_path = "/getSecure"
	connection = "keep-alive"
	parameters = None

	t=post_request(file_path, HOST, PORT, connection, parameters)
        t=t.split('Your Security Token is: ')[1].strip('"')

	return "token={}".format(t)

def flag_1():
	file_path = "/"
	connection = "close"
	parameters = None

	print(post_request(file_path, HOST, PORT, connection, parameters))
	
	return 0

def flag_2():
	file_path = "getFlag2"
	connection = "close"
	parameters = get_token()

	print(post_request(file_path, HOST, PORT, connection, parameters))

	return 0

def flag_3():
	file_path = "/getFlag3Challenge"
	connection = "keep-alive"
	parameters=get_token()

	t=post_request(file_path,HOST,PORT,connection,parameters)

	t=t.split('solve the following: ')[1].strip('"')
	t=str(eval(t))

	parameters+="&solution={}".format(t)
	connection = "close"

	print(post_request(file_path, HOST, PORT, connection, parameters))

	return 0

def flag_4():
	file_path = "/createAccount"
	connection = "keep-alive"
	parameters = get_token()+"&username=jkm"

	t=post_request(file_path,HOST,PORT,connection,parameters)

	password = t.split("your password is ")[1].strip()
	password = password.replace("&","%26")
	password = password.replace("=","%3D")

	parameters+="&password={}".format(password)

	file_path = "/login"
	connection = "close"
	
	print(post_request(file_path,HOST,PORT,connection,parameters))
	return 0

def main():
	flag_1()
	flag_2()
	flag_3()
	flag_4()

if __name__=="__main__":
	main()
