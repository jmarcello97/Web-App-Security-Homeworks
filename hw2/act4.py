#!/usr/bin/python2.7

import socket
import zlib

def main():
	s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

	s.connect(("csec380-core.csec.rit.edu", 82))

	post_request = 'POST /getSecure HTTP/1.1\r\n'
	post_request += 'Host: csec380-core.csec.rit.edu:82\r\n'
	post_request += 'Connection: keep-alive\r\n\r\n'

	s.sendall(post_request)

	t = ''
	for c in s.recv(1024):
		t+=c

	t=t.split('Your Security Token is: ')[1].strip('"')

	t="token="+t+"&username=jkm"

	post_request = 'POST /createAccount HTTP/1.1\r\n'
	post_request += 'Host: csec380-core.csec.rit.edu:82\r\n'
	post_request += "Accept: text/html, application/xhtml+xml, image/jxr, */*\r\n"
	post_request += "Accept-Language: en-US\r\n"
 	post_request += "Accept-Encoding: *\r\n"
	post_request += 'Content-Type: application/x-www-form-urlencoded\r\n'
	post_request += 'Content-Length: ' + str(len(t))+'\r\n'
	post_request += 'Connection: keep-alive\r\n'
	post_request += 'User-Agent: Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)\r\n'
	post_request += 'Cache-Control: no-cache\r\n\r\n'
	post_request += t

	s.sendall(post_request)

	flag = ''
	for c in s.recv(1024):
		flag+=c

	print(flag)
	password = flag.split('your password is ')[1].strip()
	password = password.replace("&","%26")
	password = password.replace("=","%3D")
	print(password)


	t+="&password="+password

	print(t)
	
	post_request = 'POST /login HTTP/1.1\r\n'
        post_request += 'Host: csec380-core.csec.rit.edu:82\r\n'
        post_request += "Accept: text/html, application/xhtml+xml, image/jxr, */*\r\n"
        post_request += "Accept-Language: en-US\r\n"
        post_request += "Accept-Encoding: *\r\n"
        post_request += 'Content-Type: application/x-www-form-urlencoded\r\n'
        post_request += 'Content-Length: ' + str(len(t))+'\r\n'
        post_request += 'Connection: close\r\n'
        post_request += 'User-Agent: Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)\r\n'
        post_request += 'Cache-Control: no-cache\r\n\r\n'
        post_request += t

	s.sendall(post_request)

	flag = ''
	for c in s.recv(1024):
		flag+=c

	print(flag)


if __name__=="__main__":
	main()
