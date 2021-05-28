#!/bin/bash
####
# Archives a repository
####
# @todo
#   * support more than "https://github.com/bazzline"
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
    BE_VERBOSE=0
    CURRENT_DATE=$(date +%Y%m%d)
    CURRENT_WORKING_DIRECTORY=$(pwd)
    CURRENT_YEAR=$(date +%Y)
    NAME_OF_THE_REPOSITORY="${1##*/}"   #@see: https://www.lostsaloon.com/technology/bash-find-last-occurrence-of-a-character-in-a-string/
    PATH_OF_THIS_FILE=$(cd $(dirname "${BASH_SOURCE[0]}"); pwd)
    URL_TO_THE_REPOSITORY="${1}"

    PATH_TO_THE_PROJECT_ROOT="${PATH_OF_THIS_FILE}/.."

    PATH_TO_THE_README="${PATH_TO_THE_PROJECT_ROOT}/README.md"
    PATH_TO_THE_CURRENT_ARCHIVE="${PATH_TO_THE_PROJECT_ROOT}/${CURRENT_YEAR}"

    PATH_TO_THE_CURRENT_REPOSITORY_FILE_LIST="${PATH_TO_THE_CURRENT_ARCHIVE}/.repository_file_list"
    #eo: variables

    #bo: setup
    if [[ ! -d "${PATH_TO_THE_CURRENT_ARCHIVE}" ]];
    then
        [[ $BE_VERBOSE -eq 1 ]] && echo ":: Creating path >>${PATH_TO_THE_CURRENT_ARCHIVE}<<."
        mkdir -p "${PATH_TO_THE_CURRENT_ARCHIVE}"
    fi

    if [[ ! -f ${PATH_TO_THE_CURRENT_REPOSITORY_FILE_LIST} ]];
    then
        [[ $BE_VERBOSE -eq 1 ]] && echo ":: Creating file >>${PATH_TO_THE_CURRENT_REPOSITORY_FILE_LIST}<<."
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

    [[ $BE_VERBOSE -eq 1 ]] && echo ":: Cloning repository >>${URL_TO_THE_REPOSITORY}<<."
    git clone "${URL_TO_THE_REPOSITORY}"

    [[ $BE_VERBOSE -eq 1 ]] && echo ":: Removing >>.git<< from the cloned repository"
    rm -fr "${NAME_OF_THE_REPOSITORY}/.git"

    cd "${PATH_TO_THE_PROJECT_ROOT}"

    [[ $BE_VERBOSE -eq 1 ]] && echo ":: Adding path to the repository file list."
    echo "    * [${NAME_OF_THE_REPOSITORY}](${URL_TO_THE_REPOSITORY}) - archived ${CURRENT_DATE}" >> "${PATH_TO_THE_CURRENT_REPOSITORY_FILE_LIST}"
    ##eo: repository download

    ##bo: update readme
    [[ $BE_VERBOSE -eq 1 ]] && echo ":: Updating README.md."

    cat > "${PATH_TO_THE_README}" <<DELIM
# Archive

Free as in freedom archive.

The last place on earth for dead repositories.

# Howto

\`\`\`
bash bin/archive_repository.sh "<string: url to the repository>"
\`\`\`

# Years

DELIM

    #list content of path and grep for all with the 2 inside
    for YEAR in $(ls | sort | grep 2);
    do
        echo "* [${YEAR}](${YEAR})" >> "${PATH_TO_THE_README}"

        cat "${YEAR}/.repository_file_list" | sort >> "${PATH_TO_THE_README}"
    done
    ##eo: update readme

    cd "${CURRENT_WORKING_DIRECTORY}"
}

_main $@
