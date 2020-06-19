Yii2 Asset Compile
==================
Yii2 Asset Compile

原理
-----

使用Yii2的资源转化方式，在用户浏览页面前编辑处理文件。对于CSS预编译，使用Yii2提供的方式已经完全足够使用，对于JS，
如果使用TS也能转化，但是对于ES6及以上的转化官方未提供例子。

此处给出原理如下：使用 webpack 来处理将 JS6 文件进行转化。

> 为什么要使用`.js6` 做后缀？

因为使用相同后缀 js 生成 js，这行不通，所以需要一个独特的后缀来触发转化（你可以使用你喜欢的任何后缀）

> 为什么不单独使用 `babel`，而要使用`webpack`?

单独使用 babel 可以将 ES6/ES7 等转化为 ES5，事实上最终 webpack 也是使用 babel 来转化的，webpack 最大的作用在于
可以使用 `import` 和 `export` 来将多个 js 文件合并成一个（即代码的分离）

> 相关链接

- [Yii2 Asset Conversion](https://www.yiiframework.com/doc/guide/2.0/en/structure-assets#asset-conversion)
- [babel](https://babeljs.io/)
- [webpack](https://www.webpackjs.com/)

各种工具的配置与使用
-----

### ES6/ES7 -> ES5

1. 安装依赖

```bash
# base
yarn add @babel/core babel-loader webpack webpack-cli --dev
# babel preset
yarn add @babel/preset-env --dev
# babel polyfill for IE
yarn add @babel/polyfill --dev
```

> 说明：
- 自行按需添加 preset，添加后配置文件需要做响应调整
- 此处为了兼容 IE，浏览器下需要使用 polyfill，可以使用 `kriss\assetCompile\BabelPolyfillAsset`

2. 配置

in `package.json`

```json
{
  "babel": {
    "presets": [
      "@babel/preset-env"
    ]
  }
}
```

in `webpack.config.js`，注意此处的 test 中的 `.js6`

```js
module.exports = {
  module: {
    rules: [
      { test: /\.js6|\.js$/, exclude: /node_modules/, loader: "babel-loader" }
    ]
  }
}
```

2. 增加命令

```bash
'commands' => [
    'js6' => ['js', '@npm/.bin/webpack {from} -o {to}'],
    // others
],
```

### Less

1. 安装依赖

```bash
yarn add less less-plugin-autoprefix less-plugin-clean-css --dev
```

2. 配置

in `package.json`

```json
{
  "browserslist": [
    "defaults"
  ]
}
```

3. 增加 Less 命令

```bash
'commands' => [
    'less' => ['css', '@npm/.bin/lessc {from} {to} --no-color --autoprefix --clean-css'],
    // others
],
```

> Links
> - [less](http://lesscss.cn/)
> - [less plugin](http://lesscss.cn/usage/#plugins)
> - [browsersList for autoPrefix](https://github.com/postcss/autoprefixer#browsers)

### Stylus

1. 安装依赖

```bash
yarn add stylus --dev
```

2. 增加 Stylus 命令

```bash
'commands' => [
    'styl' => ['css', '@npm/.bin/stylus --compress < {from} > {to}'],
    // others
],
```

3. Stylus 中的 import

使用`~`表示当前文件所在位置

```bash
@import "~/../common/flex.styl"
```

> Links
> - [stylus](https://stylus-lang.com/)
> - [stylus command](https://stylus-lang.com/docs/executable.html)
