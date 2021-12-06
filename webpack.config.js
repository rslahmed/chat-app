const path = require('path');
require('dotenv').config();

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
};
