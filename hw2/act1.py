#!/usr/bin/python2.7

import socket

def main():
	s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

	s.connect(("csec380-core.csec.rit.edu", 82))

	post_request = 'POST / HTTP/1.1\r\n'
	post_request += 'Host: csec380-core.csec.rit.edu:82\r\n'
	post_request += 'Connection: close\r\n\r\n'

	response = s.sendall(post_request)

	flag = ''
	for c in s.recv(1024):
		flag+=c
	
	print(flag)

if __name__=="__main__":
	main()
