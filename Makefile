# Defaults settings (when building locally)
SHELL := /bin/sh

DOCKER_REGISTRY=us.gcr.io/minhamaedizia
IMAGE_NAME=$(DOCKER_REGISTRY)/laravel_base

help:	 ## Show this help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fg

build:   ## build the image
	docker build --no-cache \
		-t $(IMAGE_NAME) .
push:    ## push the image to the docker registry
	docker push $(IMAGE_NAME)

tag: ## Tag the built image with the tag name (make tag TAG_VER=xxx)
	docker tag $(IMAGE_NAME) $(IMAGE_NAME)

pull:    ## pull an image from the docker registry
	docker pull $(IMAGE_NAME)
