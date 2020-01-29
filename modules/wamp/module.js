
import path from 'path'

export default function NuxtWampModule(_moduleOptions) {

  const options = { ...this.options.wamp, ..._moduleOptions };

  this.addPlugin({
    src: path.resolve(__dirname, 'plugin.js'),
    fileName: 'wamp.js',
    options
  });

}
