build:
	docker build -t simple-site .
run:
	docker run -d -p 8080:80 --name simple-site-web simple-site
stop:
	docker stop simple-site-web
	docker remove simple-site-web