#!/usr/bin/python2.7

import socket

def post_request(file_path, host, port, connection, parameters):
	s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

	s.connect((host, port))

	post_request = 'POST /{} HTTP/1.1\r\n'.format(file_path)
	post_request += 'Host: {}:{}\r\n'.format(host,port)
    	post_request += "Accept: text/html, application/xhtml+xml, image/jxr, */*\r\n"
	post_request += "Accept-Language: en-US\r\n"
 	post_request += "Accept-Encoding: *\r\n"
	post_request += 'Content-Type: application/x-www-form-urlencoded\r\n'
    	post_request += 'User-Agent: Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)\r\n'
	post_request += 'Cache-Control: no-cache\r\n'

	if parameters != None:
		post_request += 'Content-Length: {}\r\n'.format(len(parameters))

	post_request += 'Connection: {}\r\n\r\n'.format(connection)

	if parameters != None:
		post_request += parameters

	s.sendall(post_request)

	response = s.recv(1024)

	return response


