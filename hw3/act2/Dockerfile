FROM python:2

ADD creepy_crawler.py /

ADD user_agent.py /

RUN pip install beautifulsoup4

CMD [ "python", "./creepy_crawler.py" ]
