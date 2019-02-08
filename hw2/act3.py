#!/usr/bin/python2.7

import socket

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

	t='token='+t

	post_request = 'POST /getFlag3Challenge HTTP/1.1\r\n'
        post_request += 'Host: csec380-core.csec.rit.edu:82\r\n'
	post_request += 'Content-Type: application/x-www-form-urlencoded\r\n'
	post_request += 'Content-Length: ' + str(len(t)) +'\r\n'
        post_request += 'Connection: keep-alive\r\n\r\n'
	post_request += t 

	s.sendall(post_request)

	flag = ''
	for c in s.recv(1024):
		flag+=c

	print(flag)
	flag=flag.split('solve the following: ')[1].strip('"')
	flag=str(eval(flag))

	print(flag)

	flag='&solution='+flag
	t+=flag

	post_request = 'POST /getFlag3Challenge HTTP/1.1\r\n'
        post_request += 'Host: csec380-core.csec.rit.edu:82\r\n'
        post_request += 'Content-Type: application/x-www-form-urlencoded\r\n'
        post_request += 'Content-Length: ' + str(len(t))+'\r\n'
        post_request += 'Connection: close\r\n\r\n'
        post_request += t

	s.sendall(post_request)

	flag = ''
	for c in s.recv(1024):
		flag+=c

	print(flag)

if __name__=="__main__":
	main()
