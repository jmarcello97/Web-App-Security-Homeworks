import requests

def main():
	r = requests.get("https://csec.rit.edu")

	print(r.status_code)

	print(r.text)

if __name__=='__main__':
	main()
