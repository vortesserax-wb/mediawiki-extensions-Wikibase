'use strict';

const { assert, utils } = require( 'api-testing' );
const { expect } = require( '../helpers/chaiHelper' );
const {
	createEntity,
	createUniqueStringProperty,
	newLegacyStatementWithRandomStringValue,
	getLatestEditMetadata
} = require( '../helpers/entityHelper' );
const { newGetPropertyRequestBuilder } = require( '../helpers/RequestBuilderFactory' );
const { makeEtag } = require( '../helpers/httpHelper' );

describe( newGetPropertyRequestBuilder().getRouteDescription(), () => {
	const germanLabel = 'a-German-label-' + utils.uniq();
	const englishLabel = 'an-English-label-' + utils.uniq();
	const englishDescription = 'an-English-description-' + utils.uniq();
	const testPropertyDataType = 'wikibase-item';

	let testPropertyId;
	let testStatementPropertyId;
	let testModified;
	let testRevisionId;
	let testStatement;

	function newValidRequestBuilderWithTestProperty() {
		return newGetPropertyRequestBuilder( testPropertyId ).assertValidRequest();
	}

	before( async () => {
		testStatementPropertyId = ( await createUniqueStringProperty() ).entity.id;
		testStatement = newLegacyStatementWithRandomStringValue( testStatementPropertyId );

		const createPropertyResponse = await createEntity( 'property', {
			datatype: testPropertyDataType,
			labels: {
				de: { language: 'de', value: germanLabel },
				en: { language: 'en', value: englishLabel }
			},
			descriptions: {
				en: { language: 'en', value: englishDescription }
			},
			claims: [ testStatement ]
		} );
		testPropertyId = createPropertyResponse.entity.id;
		const testPropertyCreationMetadata = await getLatestEditMetadata( testPropertyId );
		testModified = testPropertyCreationMetadata.timestamp;
		testRevisionId = testPropertyCreationMetadata.revid;
	} );

	it( 'can GET all property data including metadata', async () => {
		const response = await newGetPropertyRequestBuilder( testPropertyId )
			.assertValidRequest()
			.makeRequest();

		expect( response ).to.have.status( 200 );

		assert.strictEqual( response.body.id, testPropertyId );
		assert.strictEqual( response.body[ 'data-type' ], testPropertyDataType );
		assert.deepEqual( response.body.aliases, {} ); // expect {}, not []
		assert.deepEqual( response.body.labels, {
			de: germanLabel,
			en: englishLabel
		} );
		assert.deepEqual( response.body.descriptions, { en: englishDescription } );

		assert.strictEqual(
			response.body.statements[ testStatementPropertyId ][ 0 ].value.content,
			testStatement.mainsnak.datavalue.value
		);

		assert.equal( response.header[ 'last-modified' ], testModified );
		assert.equal( response.header.etag, makeEtag( testRevisionId ) );
	} );

	it( 'can GET a partial property with single _fields param', async () => {
		const response = await newValidRequestBuilderWithTestProperty()
			.withQueryParam( '_fields', 'labels' )
			.makeRequest();

		expect( response ).to.have.status( 200 );
		assert.deepEqual( response.body, {
			id: testPropertyId,
			labels: {
				de: germanLabel,
				en: englishLabel
			}
		} );
		assert.equal( response.header[ 'last-modified' ], testModified );
		assert.equal( response.header.etag, makeEtag( testRevisionId ) );
	} );

	it( 'can GET a partial property with multiple _fields params', async () => {
		const response = await newValidRequestBuilderWithTestProperty()
			.withQueryParam( '_fields', 'labels,descriptions,aliases' )
			.makeRequest();

		expect( response ).to.have.status( 200 );
		assert.deepEqual( response.body, {
			id: testPropertyId,
			labels: {
				de: germanLabel,
				en: englishLabel
			},
			descriptions: {
				en: englishDescription
			},
			aliases: {} // expect {}, not []
		} );
		assert.equal( response.header[ 'last-modified' ], testModified );
		assert.equal( response.header.etag, makeEtag( testRevisionId ) );
	} );

	it( '400 error - invalid property id', async () => {
		const propertyId = 'X123';
		const response = await newGetPropertyRequestBuilder( propertyId ).makeRequest();

		expect( response ).to.have.status( 400 );
		assert.header( response, 'Content-Language', 'en' );
		assert.equal( response.body.code, 'invalid-property-id' );
		assert.include( response.body.message, propertyId );
	} );

	it( '404 error - property not found', async () => {
		const propertyId = 'P999999';
		const response = await newGetPropertyRequestBuilder( propertyId ).makeRequest();

		expect( response ).to.have.status( 404 );
		assert.header( response, 'Content-Language', 'en' );
		assert.equal( response.body.code, 'property-not-found' );
		assert.include( response.body.message, propertyId );
	} );

} );
