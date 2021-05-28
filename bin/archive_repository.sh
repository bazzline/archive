#!/bin/bash
####
# Archives a repository
####
# @todo
#   * support more than "https://github.com/bazzline"
#   * order content of readme listed repositories alphabetically
####
# @since: 2021-05-28
# @author: stev leibelt <artodeto@bazzline.net>
####

function _main ()
{
    #bo: input validation
    if [[ $# -lt 1 ]];
    then
        echo ":: Usage"
        echo "   archive_repository.sh <string: url to the repository>"
    fi
    #eo: input validation

    #bo: variables
    CURRENT_DATE=$(date +%Y%m%d)
    CURRENT_WORKING_DIRECTORY=$(pwd)
    CURRENT_YEAR=$(date +%Y)
    NAME_OF_THE_REPOSITORY="${1##*/}"   #@see: https://www.lostsaloon.com/technology/bash-find-last-occurrence-of-a-character-in-a-string/
    PATH_OF_THIS_FILE=$(cd $(dirname "${BASH_SOURCE[0]}"); pwd)
    URL_TO_THE_REPOSITORY="${1}"

    PATH_TO_THE_PROJECT_ROOT="${PATH_OF_THIS_FILE}/.."

    PATH_TO_THE_CURRENT_ARCHIVE="${PATH_TO_THE_PROJECT_ROOT}/${CURRENT_YEAR}"

    PATH_TO_THE_CURRENT_REPOSITORY_FILE_LIST="${PATH_TO_THE_CURRENT_ARCHIVE}/.repository_file_list"
    #eo: variables

    #bo: setup
    if [[ ! -d "${PATH_TO_THE_CURRENT_ARCHIVE}" ]];
    then
        mkdir -p "${PATH_TO_THE_CURRENT_ARCHIVE}"
    fi

    if [[ ! -f ${PATH_TO_THE_CURRENT_REPOSITORY_FILE_LIST} ]];
    then
        touch "${PATH_TO_THE_CURRENT_REPOSITORY_FILE_LIST}"
    fi
    #eo: setup

    #bo: repository download
    cd "${PATH_TO_THE_CURRENT_ARCHIVE}"

    if [[ -d "${NAME_OF_THE_REPOSITORY}" ]];
    then
        echo ":: Repository is already archived."
        echo "   Path >>${PATH_TO_THE_CURRENT_ARCHIVE}/${NAME_OF_THE_REPOSITORY}<< exists already."

        return 1
    fi

    echo "git clone \"${URL_TO_THE_REPOSITORY}\""

    echo "rm -fr \"${NAME_OF_THE_REPOSITORY}/.git\""

    echo "[${NAME_OF_THE_REPOSITORY}](${URL_TO_THE_REPOSITORY}) - archived ${CURRENT_DATE}" >> "${PATH_TO_THE_CURRENT_REPOSITORY_FILE_LIST}"
    ##eo: repository download

    cd "${CURRENT_WORKING_DIRECTORY}"
}

_main $@
