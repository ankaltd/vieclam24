// utils.js



export function getParameterValue(parameterName) {

  const currentURL = window.location.href;

  const queryString = currentURL.split("?")[1];

  const params = {};



  if (queryString) {

    const paramPairs = queryString.split("&");

    paramPairs.forEach(function (pair) {

      const keyValue = pair.split("=");

      const key = decodeURIComponent(keyValue[0]);

      const value = decodeURIComponent(keyValue[1]);

      params[key] = value;

    });

  }



  return params[parameterName] || null;

}

