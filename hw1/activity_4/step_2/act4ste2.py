import requests
import netaddr
import sys

def main():
	ports = ["80","8080","8000"]
	beginning_ip = netaddr.IPAddress(sys.argv[1])
	end_ip = netaddr.IPAddress(sys.argv[2])

	for ip in range(int(beginning_ip), int(end_ip)):
		ip="http://"+str(netaddr.IPAddress(ip))
		print(ip)
		for port in ports:
			proxy=ip+":"+port
			try:
				r = requests.get('http://google.com', proxies={'http': proxy}, timeout=4.0)
				if r.status_code == 200:
					print(proxy + " is an open proxy")
			except:
				pass
main()
