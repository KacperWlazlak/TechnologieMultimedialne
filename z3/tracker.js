(function () {
    const ua = navigator.userAgent;

    function getBrowser() {
        let match;

        // Microsoft Edge
        match = ua.match(/Edg(?:A|iOS)?\/([\d.]+)/);
        if (match) {
            return "Microsoft Edge " + match[1];
        }

        // Opera
        match = ua.match(/OPR\/([\d.]+)/);
        if (match) {
            return "Opera " + match[1];
        }

        // Firefox
        match = ua.match(/(?:Firefox|FxiOS)\/([\d.]+)/);
        if (match) {
            return "Mozilla Firefox " + match[1];
        }

        // Chrome
        match = ua.match(/(?:Chrome|CriOS)\/([\d.]+)/);
        if (match) {
            return "Google Chrome " + match[1];
        }

        // Safari
        if (/Safari\//.test(ua)) {
            match = ua.match(/Version\/([\d.]+)/);
            if (match) {
                return "Safari " + match[1];
            }
        }

        return "Nieznana przeglądarka";
    }

    const data = {
        browser: getBrowser(),
        screen: screen.width + "x" + screen.height,
        window: window.innerWidth + "x" + window.innerHeight,
        colors: screen.colorDepth,
        cookies: navigator.cookieEnabled,
        java: typeof navigator.javaEnabled === "function"
            ? navigator.javaEnabled()
            : false,
        language: navigator.language
    };

    fetch('zapisz_wizyte.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data),
        keepalive: true
    }).catch(console.error);
})();
