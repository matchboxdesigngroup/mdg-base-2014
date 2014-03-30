module.exports =
  prod:
    options:
      url: "http://site.com/"
      locale: "en_US"
      strategy: "desktop"
      threshold: 80

  paths:
    options:
      paths: [
        "/path/to/page1"
        "/path/to/page2"
      ]
      locale: "en_US"
      strategy: "desktop"
      threshold: 80

  options:
    key: "API_KEY" # https://developers.google.com/speed/docs/insights/v1/getting_started#auth
    url: "https://developers.google.com"