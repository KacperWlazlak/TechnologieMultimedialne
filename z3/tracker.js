(function () {
    const ua = navigator.userAgent;

    function getBrowser() {
        if (/Edg\//.test(ua)) return "Microsoft Edge";
        if (/OPR\//.test(ua)) return "Opera";
        if (/Firefox\//.test(ua)) return "Firefox";
        if (/Chrome\//.test(ua)) return "Google Chrome";
        if (/Safari\//.test(ua)) return "Safari";
        return "Inna / nieznana";
    }

    const data = {
        browser: getBrowser(),
        screen: screen.width + "x" + screen.height,
        window: window.innerWidth + "x" + window.innerHeight,
        colors: screen.colorDepth,
        cookies: navigator.cookieEnabled,
        java: typeof navigator.javaEnabled === "function"
            ? navigator.javaEnabled() : false,
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
