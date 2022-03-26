module.exports = {
  root: true,
  env: {
    browser: true,
    node: true
  },
  parserOptions: {
    parser: '@babel/eslint-parser',
    requireConfigFile: false
  },
  extends: [
    '@nuxtjs',
    'plugin:nuxt/recommended'
  ],
  plugins: [
  ],
  // add your custom rules here
  rules: {
    "object-curly-newline": ["off", {
    "ObjectExpression": "always",
    "ObjectPattern": { "multiline": true },
    "ImportDeclaration": "never",
    "ExportDeclaration": { "multiline": true, "minProperties": 3 }}],
    "skipBlankLines": 0,
    "vue/multi-word-component-names": ["off", "never"],
    'indent': 0,
    'no-traling-spaces':0,
    "comma-dangle": ["off", "never"],
    'no-trailing-spaces':0,
    'key-spacing':0,
    'curly':0,
    'object-curly-spacing':0,
    'comma-spacing':0
  }
}
