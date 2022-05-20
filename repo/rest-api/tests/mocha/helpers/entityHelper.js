'use strict';

const { action, utils } = require( 'api-testing' );

async function createEntity( type, entity ) {
	return action.getAnon().action( 'wbeditentity', {
		new: type,
		token: '+\\',
		data: JSON.stringify( entity )
	}, 'POST' );
}

async function createSingleItem() {
	const createPropertyResponse = await createEntity( 'property', {
		labels: { en: { language: 'en', value: `string-property-${utils.uniq()}` } },
		datatype: 'string'
	} );
	const stringPropId = createPropertyResponse.entity.id;

	const item = {
		labels: { en: { language: 'en', value: `non-empty-item-${utils.uniq()}` } },
		descriptions: { en: { language: 'en', value: 'non-empty-item-description' } },
		aliases: { en: [ { language: 'en', value: 'non-empty-item-alias' } ] },
		claims: [
			{ // with value, without qualifiers or references
				mainsnak: {
					snaktype: 'value',
					property: stringPropId,
					datavalue: { value: 'im a statement value', type: 'string' }
				}, type: 'statement', rank: 'normal'
			},
			{ // no value, with qualifier and reference
				mainsnak: {
					snaktype: 'novalue',
					property: stringPropId
				},
				type: 'statement',
				rank: 'normal',
				qualifiers: [
					{
						snaktype: 'value',
						property: stringPropId,
						datavalue: { value: 'im a qualifier value', type: 'string' }
					}
				],
				references: [ {
					snaks: [ {
						snaktype: 'value',
						property: stringPropId,
						datavalue: { value: 'im a reference value', type: 'string' }
					} ]
				} ]
			}
		]
	};

	return await createEntity( 'item', item );
}

/**
 * @param {string} redirectTarget - the id of the item to redirect to (target)
 * @return {Promise<string>} - the id of the item to redirect from (source)
 */
async function createRedirectForItem( redirectTarget ) {
	const redirectSource = ( await createEntity( 'item', {} ) ).entity.id;
	await action.getAnon().action( 'wbcreateredirect', {
		from: redirectSource,
		to: redirectTarget,
		token: '+\\'
	}, true );

	return redirectSource;
}

module.exports = {
	createEntity,
	createSingleItem,
	createRedirectForItem
};