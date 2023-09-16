function checkIP(ip) {
    let x = ip.split("."), x1, x2, x3, x4;

    if (x.length === 4) {
        x1 = parseInt(x[0], 10);
        x2 = parseInt(x[1], 10);
        x3 = parseInt(x[2], 10);
        x4 = parseInt(x[3], 10);

        if (isNaN(x1) || isNaN(x2) || isNaN(x3) || isNaN(x4)) {
            return false;
        }

        if ((x1 >= 0 && x1 <= 255) && (x2 >= 0 && x2 <= 255) && (x3 >= 0 && x3 <= 255) && (x4 >= 0 && x4 <= 255)) {
            return true;
        }
    }
    return false;
}

function checkDomain(domain) {
    let withProtocol = /^(ftp|http|https):\/\/[^ "]+$/.test(domain)
    let withoutProtocol = /^www\.[^ "]+$/.test(domain)
    let withoutSubdomain = /^[a-zA-Z\d][a-zA-Z\d-]{1,61}[a-zA-Z\d]\.[a-zA-Z]{2,}$/.test(domain)
    let withSubdomain = /^[a-zA-Z\d]{1,61}\.[^ "]+$/.test(domain)
    return withProtocol || withoutProtocol || withoutSubdomain || withSubdomain
}

module.exports = {
    checkIP,
    checkDomain
}