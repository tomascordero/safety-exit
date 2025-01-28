const isValidUrl = urlString=> {
    var urlPattern = new RegExp(/(?:http[s]?:\/\/.)?(?:www\.)?[-a-zA-Z0-9@%._\+~#=]{2,256}\.[a-z]{2,10}\b(?:[-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/, 'gm');
    return !!urlPattern.test(urlString);
}

export { isValidUrl };
