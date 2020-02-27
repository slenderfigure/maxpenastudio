class InputFilter {
    static nameFilter(name) {
        const NAME = /^[A-Za-z]+\s?[A-Za-z]+?$/;

        return NAME.test(name);
    }

    static emailFilter(email) {
        const EMAIL = /^[a-zA-Z!#$%&'*+/=?^_`{|}~-]+[0-9a-zA-Z!#$%&'*+/=?^_`{|}~.]*?@[a-z]+\.(com|net|org|gov|edu|do)$/;

        return EMAIL.test(email);
    }

    static usernameFilter(username) {
        const USERNAME = /^[A-Za-z0-9]+$/;

        return USERNAME.test(username);
    }

    static passwordFilter(password) {
        const LOW_CHAR = /[a-z]+/;
        const UP_CHAR  = /[A-Z]+/;
        const NUM_CHAR = /[0-9]+/;
        const SPL_CHAR = /[.!@#$%&'*+/=?^_`(){|}~,:;\s-]+/;
        const INP_LEN  = /.{8,}/;   
        const PASS_MATCH = LOW_CHAR.test(password) && UP_CHAR.test(password) &&
        NUM_CHAR.test(password) && SPL_CHAR.test(password) && INP_LEN.test(password);

        return PASS_MATCH;
    }
}