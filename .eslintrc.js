module.exports = {
    "env": {
        "browser": true,
        "es6": true
    },
    "extends": "eslint:recommended",
    "parserOptions": {
        "ecmaFeatures": {
            "experimentalObjectRestSpread": true,
            "jsx": true
        },
        "sourceType": "module"
    },
    "plugins": [
        "react"
    ],
    "settings": {
        "react": {
            "createClass": "createClass", // Regex for Component Factory to use, default to "createClass"
            "pragma": "React",  // Pragma to use, default to "React"
            "version": "15.0" // React version, default to the latest React stable release
        }
    },
    "rules": {
        "indent": [
            "error",
            4
        ],
        "linebreak-style": [
            "error",
            "windows"
        ],
        "quotes": [
            "error",
            "single"
        ],
        "semi": [
            "error",
            "always"
        ],
       "no-console":0,
       "linebreak-style":0,
       "react/jsx-uses-react": "error",
       "react/jsx-uses-vars": "error"
    }
};
