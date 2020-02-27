class ServerRequest {
    static createXHL(path) {
        let xhl = new XMLHttpRequest();
        
        xhl.open('GET', path, true);
        return xhl;
    }
}