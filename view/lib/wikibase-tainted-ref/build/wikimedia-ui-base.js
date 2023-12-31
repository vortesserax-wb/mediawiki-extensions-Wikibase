/**
 * Translates variables provided by https://www.npmjs.com/package/wikimedia-ui-base
 * to SCSS and stores it alongside this package for use in our styles
 */
const fs = require( 'fs' );
const gonzales = require( 'gonzales-pe' );
const lessVariableResolver = require( 'less-variable-resolver' );
const sast = require( 'sast' );
const WIKIMEDIA_UI_BASE_DIR = `${__dirname}/../node_modules/wikimedia-ui-base`;
const lessTree = gonzales.parse(
	fs.readFileSync( `${WIKIMEDIA_UI_BASE_DIR}/wikimedia-ui-base.less`, 'utf8' ),
	{ syntax: 'less' },
);
lessVariableResolver.log.level = process.argv.includes( '--debug' ) ? 'debug' : 'warn';
lessVariableResolver.resolveVariablesInTree( lessTree );
const scssTree = sast.parse( lessTree.toString(), { syntax: 'less' } );
fs.writeFileSync(
	`${WIKIMEDIA_UI_BASE_DIR}/_wikimedia-ui-base.scss`,
	`// Autogenerated by dataBridge build process
// All variables are resolved - check the original less file to understand their relation
${sast.stringify( scssTree )}`,
);
