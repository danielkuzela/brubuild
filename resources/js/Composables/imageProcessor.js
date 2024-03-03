export function extractSizeFromFileName(fileName) {
    const sizeMatch = fileName.match(/_(\d+)_(\d+)\.jpg$/);
    if (sizeMatch) {
        const width = parseInt(sizeMatch[1], 10);
        const height = parseInt(sizeMatch[2], 10);
        return { width, height };
    }
    return null;
}

export function generateSrcset(urls, maxWidth, dir) {
    const sizes = [];
    let currentSize = maxWidth;

    for (let i = 0; i < urls.length; i++) {
        const url = urls[i];

        if(i === 0){
            const sizeInfo = extractSizeFromFileName(url);
            if (sizeInfo) {
                currentSize = sizeInfo.width;
            }
        }

        sizes.push(`${dir + url} ${currentSize}w`);
        currentSize = Math.floor(currentSize * 0.837);
    }

    return sizes.join(', ');
}
