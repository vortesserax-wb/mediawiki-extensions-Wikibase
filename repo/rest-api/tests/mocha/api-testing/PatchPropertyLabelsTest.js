'use strict';

const { assert, utils, action } = require( 'api-testing' );
const { expect } = require( '../helpers/chaiHelper' );
const entityHelper = require( '../helpers/entityHelper' );
const { newPatchPropertyLabelsRequestBuilder } = require( '../helpers/RequestBuilderFactory' );
const { makeEtag } = require( '../helpers/httpHelper' );
const { formatLabelsEditSummary } = require( '../helpers/formatEditSummaries' );
const testValidatesPatch = require( '../helpers/testValidatesPatch' );

function assertValid400Response( response, responseBodyErrorCode, context = null ) {
	expect( response ).to.have.status( 400 );
	assert.header( response, 'Content-Language', 'en' );
	assert.strictEqual( response.body.code, responseBodyErrorCode );
	if ( context === null ) {
		assert.notProperty( response.body, 'context' );
	} else {
		assert.deepStrictEqual( response.body.context, context );
	}
}

describe( newPatchPropertyLabelsRequestBuilder().getRouteDescription(), () => {

	let testPropertyId;
	let originalLastModified;
	let originalRevisionId;

	before( async function () {
		testPropertyId = ( await entityHelper.createUniqueStringProperty() ).entity.id;

		const testPropertyCreationMetadata = await entityHelper.getLatestEditMetadata( testPropertyId );
		originalLastModified = new Date( testPropertyCreationMetadata.timestamp );
		originalRevisionId = testPropertyCreationMetadata.revid;

		// wait 1s before modifying labels to verify the last-modified timestamps are different
		await new Promise( ( resolve ) => {
			setTimeout( resolve, 1000 );
		} );
	} );

	describe( '200 OK', () => {
		it( 'can add a label', async () => {
			const label = `new english label ${utils.uniq()}`;
			const response = await newPatchPropertyLabelsRequestBuilder(
				testPropertyId,
				[
					{ op: 'add', path: '/en', value: label }
				]
			).makeRequest();

			expect( response ).to.have.status( 200 );
			assert.strictEqual( response.body.en, label );
			assert.strictEqual( response.header[ 'content-type' ], 'application/json' );
			assert.isAbove( new Date( response.header[ 'last-modified' ] ), originalLastModified );
			assert.notStrictEqual( response.header.etag, makeEtag( originalRevisionId ) );
		} );

		it( 'can patch labels with edit metadata', async () => {
			const label = `new arabic label ${utils.uniq()}`;
			const user = await action.robby(); // robby is a bot
			const tag = await action.makeTag( 'e2e test tag', 'Created during e2e test' );
			const editSummary = 'I made a patch';
			const response = await newPatchPropertyLabelsRequestBuilder(
				testPropertyId,
				[
					{
						op: 'add',
						path: '/ar',
						value: label
					}
				]
			).withJsonBodyParam( 'tags', [ tag ] )
				.withJsonBodyParam( 'bot', true )
				.withJsonBodyParam( 'comment', editSummary )
				.withUser( user )
				.assertValidRequest().makeRequest();

			expect( response ).to.have.status( 200 );
			assert.strictEqual( response.body.ar, label );
			assert.strictEqual( response.header[ 'content-type' ], 'application/json' );
			assert.isAbove( new Date( response.header[ 'last-modified' ] ), originalLastModified );
			assert.notStrictEqual( response.header.etag, makeEtag( originalRevisionId ) );

			const editMetadata = await entityHelper.getLatestEditMetadata( testPropertyId );
			assert.include( editMetadata.tags, tag );
			assert.property( editMetadata, 'bot' );
			assert.strictEqual(
				editMetadata.comment,
				formatLabelsEditSummary( 'update-languages-short', 'ar', editSummary )
			);
		} );
	} );

	describe( '400 error response', () => {
		it( 'invalid property id', async () => {
			const propertyId = testPropertyId.replace( 'P', 'L' );
			const response = await newPatchPropertyLabelsRequestBuilder( propertyId, [] )
				.assertInvalidRequest().makeRequest();

			assertValid400Response( response, 'invalid-property-id', { 'property-id': propertyId } );
			assert.include( response.body.message, propertyId );
		} );

		testValidatesPatch( ( patch ) => newPatchPropertyLabelsRequestBuilder( testPropertyId, patch ) );

		it( 'invalid edit tag', async () => {
			const invalidEditTag = 'invalid tag';
			const response = await newPatchPropertyLabelsRequestBuilder( testPropertyId, [] )
				.withJsonBodyParam( 'tags', [ invalidEditTag ] ).assertValidRequest().makeRequest();

			assertValid400Response( response, 'invalid-edit-tag' );
			assert.include( response.body.message, invalidEditTag );
		} );

		it( 'invalid edit tag type', async () => {
			const response = await newPatchPropertyLabelsRequestBuilder( testPropertyId, [] )
				.withJsonBodyParam( 'tags', 'not an array' ).assertInvalidRequest().makeRequest();

			expect( response ).to.have.status( 400 );
			assert.strictEqual( response.body.code, 'invalid-request-body' );
			assert.strictEqual( response.body.fieldName, 'tags' );
			assert.strictEqual( response.body.expectedType, 'array' );
		} );

		it( 'invalid bot flag type', async () => {
			const response = await newPatchPropertyLabelsRequestBuilder( testPropertyId, [] )
				.withJsonBodyParam( 'bot', 'not boolean' ).assertInvalidRequest().makeRequest();

			expect( response ).to.have.status( 400 );
			assert.strictEqual( response.body.code, 'invalid-request-body' );
			assert.strictEqual( response.body.fieldName, 'bot' );
			assert.strictEqual( response.body.expectedType, 'boolean' );
		} );

		it( 'comment too long', async () => {
			const comment = 'x'.repeat( 501 );
			const response = await newPatchPropertyLabelsRequestBuilder( testPropertyId, [] )
				.withJsonBodyParam( 'comment', comment ).assertValidRequest().makeRequest();

			assertValid400Response( response, 'comment-too-long' );
			assert.include( response.body.message, '500' );
		} );

		it( 'invalid comment type', async () => {
			const response = await newPatchPropertyLabelsRequestBuilder( testPropertyId, [] )
				.withJsonBodyParam( 'comment', 1234 ).assertInvalidRequest().makeRequest();

			expect( response ).to.have.status( 400 );
			assert.strictEqual( response.body.code, 'invalid-request-body' );
			assert.strictEqual( response.body.fieldName, 'comment' );
			assert.strictEqual( response.body.expectedType, 'string' );
		} );
	} );

	describe( '404 error response', () => {
		it( 'property not found', async () => {
			const propertyId = 'P99999';
			const response = await newPatchPropertyLabelsRequestBuilder(
				propertyId,
				[
					{
						op: 'replace',
						path: '/en',
						value: utils.uniq()
					}
				]
			).assertValidRequest().makeRequest();

			expect( response ).to.have.status( 404 );
			assert.strictEqual( response.header[ 'content-language' ], 'en' );
			assert.strictEqual( response.body.code, 'property-not-found' );
			assert.include( response.body.message, propertyId );
		} );
	} );

} );
