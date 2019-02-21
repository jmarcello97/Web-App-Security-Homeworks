#!/usr/bin/python2.7

import socket
import ssl

def request(request_type, file_path, host, port, connection, parameters):
	#if "https" in file_path:
	#	port=443
	#else:
	#	port=80
	s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
	s.settimeout(4)	
	if port == 443:
		s = ssl.wrap_socket(s)

	try:
		s.connect((host, port))
	except socket.error, exc:
		print("Caught exception socket.error : %s" % exc)
		return 1

	post_request = '{} {} HTTP/1.1\r\n'.format(request_type, file_path)
	post_request += 'Host: {}\r\n'.format(host)
	post_request += "Accept: */*\r\n"
	#post_request += "User-Agent: python-requests/2.13.0\r\n"
    	#post_request += "Accept: text/html, application/xhtml+xml, image/jpeg, */*\r\n"
	#post_request += "Accept-Language: en-US\r\n"
 	#post_request += "Accept-Encoding: gzip, deflate, https\r\n"
	#post_request += 'Content-Type: application/x-www-form-urlencoded\r\n'
    	#post_request += 'User-Agent: Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)\r\n'
	#post_request += 'Cache-Control: no-cache\r\n'

	if parameters != None:
		post_request += 'Content-Length: {}\r\n'.format(len(parameters))

	post_request += 'Connection: {}\r\n\r\n'.format(connection)

	if parameters != None:
		post_request += parameters

	#print(post_request)

	try:
		s.send(post_request)

		response=""
		while True:
			r=s.recv(4096)
			if r:
				response+=r
			else:
				break

	except Exception, e:
		print("Exception {0} occurred".format(e))
		#continue

	if "200 OK" not in response:
		return 1
	return response

