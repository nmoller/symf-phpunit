#!/usr/bin/env bash

# From https://github.com/moodlehq/moodle-docker/blob/master/bin/moodle-docker-compose
SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
  DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
done
HOME_DIR="$( cd -P "$( dirname "$SOURCE" )/../" && pwd )"

RUN=0
STOP=0
CONTAINER="symfserve"
RUNNING=$(docker ps --format '{{.Names}}')
STOPED=$(docker container ls -f 'status=exited' --format {{.Names}})

for c in $RUNNING
do
  if [ "$c" = "$CONTAINER" ]
  then
    RUN=1
    break
  fi
done

for a in $STOPED
do
  if [ "$a" = "$CONTAINER" ]
  then
    STOP=1
    break
  fi
done

if [ "$STOP" = 1 ]
then
  docker start $CONTAINER
  RUN=1
fi

if [ "$RUN" = 0 ]
then
  "docker run -it --name symfserve -v $HOME_DIR:/opt/messenger \
  --network host \
  -e COMPOSER_CACHE_DIR=/opt/messenger/.composer \
  -w /opt/messenger \
  nmolleruq/phpcomposer:7.4 bash" &
fi


docker exec -it  symfserve  $@