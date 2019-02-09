FROM ubuntu

COPY step1.py ./

COPY user_agent.py ./

RUN apt-get -y update

RUN apt-get -y install python-pip python-dev build-essential

RUN pip install beautifulsoup4

CMD python step1.py
