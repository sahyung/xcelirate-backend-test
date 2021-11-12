# [Xcelirate Backend Test](https://github.com/Xcelirate/backend_test)

## Basic info

* [nginx](https://nginx.org/)
* [PHP-FPM](https://php-fpm.org/)
* [MySQL](https://www.mysql.com/)
* [Redis](https://redis.io/)
* [Elasticsearch](https://www.elastic.co/products/elasticsearch)
* [Logstash](https://www.elastic.co/products/logstash)
* [Kibana](https://www.elastic.co/products/kibana)
* [RabbitMQ](https://www.rabbitmq.com/)

## Showcase

[![steve-jobs.png](https://i.ibb.co/h1GRFK5/showcase.png)](https://i.ibb.co/h1GRFK5/showcase.png)

## Tests

PHPSpec <br>
[![phpspec.png](https://i.ibb.co/KDm6FSq/phpspec.png)](https://i.ibb.co/KDm6FSq/phpspec.png)

Behat <br>
[![behat.png](https://i.ibb.co/tcq551g/behat.png)](https://i.ibb.co/tcq551g/behat.png)


## Installation

1. Everything is done by running `./make_dev` or by double clicking `make_dev` file in UNIX.

2. Unit test done with PHPSpec and integration test with Behat, each shown by running `vendor/bin/phpspec run` and `vendor/bin/behat` respectively.

## How does it work?

The basic workflow can be seen on the `quotes.feature` file from the integration test.
Message queueing is kept-alive with Supervisor.

The following built images are included:

* `nginx`: The Nginx webserver container in which the application volume is mounted.
* `php`: The PHP-FPM container in which the application volume is mounted too.
* `mysql`: The MySQL database container.
* `elk`: Container which uses Logstash to collect logs, send them into Elasticsearch and visualize them with Kibana.
* `redis`: The Redis server container.
* `rabbitmq`: The RabbitMQ server/administration container.

Running `docker-compose ps` should result in the following running containers:

```
      Name                    Command               State                                                     Ports                                                  
---------------------------------------------------------------------------------------------------------------------------------------------------------------------
container_elk      /usr/local/bin/start.sh          Up      0.0.0.0:5044->5044/tcp,:::5044->5044/tcp, 0.0.0.0:5601->5601/tcp,:::5601->5601/tcp,                      
                                                            0.0.0.0:9200->9200/tcp,:::9200->9200/tcp, 9300/tcp, 9600/tcp                                             
container_mysql    docker-entrypoint.sh mysqld      Up      0.0.0.0:3306->3306/tcp,:::3306->3306/tcp, 33060/tcp                                                      
container_nginx    nginx                            Up      443/tcp, 0.0.0.0:80->80/tcp,:::80->80/tcp                                                                
container_php      docker-php-entrypoint php-fpm    Up      9000/tcp                                                                                                 
container_rabbit   docker-entrypoint.sh rabbi ...   Up      15671/tcp, 0.0.0.0:15672->15672/tcp,:::15672->15672/tcp, 15691/tcp, 15692/tcp, 25672/tcp, 4369/tcp,      
                                                            5671/tcp, 0.0.0.0:5672->5672/tcp,:::5672->5672/tcp                                                       
container_redis    docker-entrypoint.sh redis ...   Up      0.0.0.0:6379->6379/tcp,:::6379->6379/tcp   
```

## Usage

Once all the containers are up, the services are available at:

* Symfony app: `http://symfony.dev:80` or just `http://symfony.dev`
* Mysql server: `symfony.dev:3306`
* Redis: `symfony.dev:6379`
* Elasticsearch: `symfony.dev:9200`
* Kibana: `http://symfony.dev:5601`
* RabbitMQ: `http://symfony.dev:15672`
* Log files location: *logs/nginx* and *logs/symfony*

---

Inspired by [eko/docker-symfony](https://github.com/eko/docker-symfony) and [maxpou/docker-symfony](https://github.com/maxpou/docker-symfony)
