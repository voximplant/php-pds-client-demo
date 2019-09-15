FROM php:7.3-cli
RUN apt-get update
RUN apt-get install libz-dev
RUN pecl install grpc
WORKDIR /usr/src/myapp
CMD [ "php", "-d", "extension=grpc.so", "./client.php" ]

# command for build: docker build -t pds_client .
# command for run:
#   linux: docker run --rm -t -v $PWD:/usr/src/myapp pds_client
#   windows: docker run --rm -t -v %CD%:/usr/src/myapp pds_client

#NOTE: commands can run only from project folder
