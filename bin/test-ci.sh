#!/usr/bin/env bash

WP_VERSION=${WP_VERSION-4.3.1}

projectName=$(git remote show origin | grep "Fetch URL:" | sed "s#^.*/\(.*\).git#\1#")
authorMail=$(git --no-pager show -s --format="%aE" HEAD)

wpPath="tmp/wp-${WP_VERSION}"
pluginPath=${wpPath}/wp-content/plugins/${projectName}

./bin/wp core download --path=${wpPath} --version=$WP_VERSION

./bin/wp --path=$wpPath core config \
	--dbname=${projectName}_${WP_VERSION}_test \
	--dbuser=root

./bin/wp --path=$wpPath db drop --yes > /dev/null
./bin/wp --path=$wpPath db create

./bin/wp --path=$wpPath core install \
	--url="http://127.0.0.1" \
	--title="${projectName}" \
	--admin_user="admin" \
	--admin_password="password123" \
	--admin_email="${authorMail}"

rsync -az --exclude=".git" --exclude="tmp" . ${pluginPath} > /dev/null

./bin/wp --path=${wpPath} plugin activate ${projectName}

cd ${pluginPath}

./bin/test-med.sh