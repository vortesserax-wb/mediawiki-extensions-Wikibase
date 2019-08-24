<?php
// This file is generated by build/generateAutoload.php, do not adjust manually
// phpcs:disable Generic.Files.LineLength
global $wgAutoloadClasses;

$wgAutoloadClasses += [
	'Wikibase\\AddUnitConversions' => __DIR__ . '/maintenance/addUnitConversions.php',
	'Wikibase\\Build\\PopulateWithRandomEntitiesAndTerms' => __DIR__ . '/maintenance/populateWithRandomEntitiesAndTerms.php',
	'Wikibase\\ChangePropertyDataType' => __DIR__ . '/maintenance/changePropertyDataType.php',
	'Wikibase\\ClaimSummaryBuilder' => __DIR__ . '/includes/ClaimSummaryBuilder.php',
	'Wikibase\\ClearTermSqlIndexSearchFields' => __DIR__ . '/maintenance/clearTermSqlIndexSearchFields.php',
	'Wikibase\\Content\\DeferredCopyEntityHolder' => __DIR__ . '/includes/Content/DeferredCopyEntityHolder.php',
	'Wikibase\\Content\\DeferredDecodingEntityHolder' => __DIR__ . '/includes/Content/DeferredDecodingEntityHolder.php',
	'Wikibase\\Content\\EntityHolder' => __DIR__ . '/includes/Content/EntityHolder.php',
	'Wikibase\\Content\\EntityInstanceHolder' => __DIR__ . '/includes/Content/EntityInstanceHolder.php',
	'Wikibase\\CopyrightMessageBuilder' => __DIR__ . '/includes/CopyrightMessageBuilder.php',
	'Wikibase\\DataTypeSelector' => __DIR__ . '/includes/DataTypeSelector.php',
	'Wikibase\\DispatchChanges' => __DIR__ . '/maintenance/dispatchChanges.php',
	'Wikibase\\DumpEntities' => __DIR__ . '/maintenance/DumpEntities.php',
	'Wikibase\\DumpJson' => __DIR__ . '/maintenance/dumpJson.php',
	'Wikibase\\DumpRdf' => __DIR__ . '/maintenance/dumpRdf.php',
	'Wikibase\\Dumpers\\DumpGenerator' => __DIR__ . '/includes/Dumpers/DumpGenerator.php',
	'Wikibase\\Dumpers\\JsonDumpGenerator' => __DIR__ . '/includes/Dumpers/JsonDumpGenerator.php',
	'Wikibase\\Dumpers\\RdfDumpGenerator' => __DIR__ . '/includes/Dumpers/RdfDumpGenerator.php',
	'Wikibase\\EditEntityAction' => __DIR__ . '/includes/Actions/EditEntityAction.php',
	'Wikibase\\EntityContent' => __DIR__ . '/includes/Content/EntityContent.php',
	'Wikibase\\HistoryEntityAction' => __DIR__ . '/includes/Actions/HistoryEntityAction.php',
	'Wikibase\\IdGenerator' => __DIR__ . '/includes/Store/IdGenerator.php',
	'Wikibase\\ItemContent' => __DIR__ . '/includes/Content/ItemContent.php',
	'Wikibase\\ItemDisambiguation' => __DIR__ . '/includes/ItemDisambiguation.php',
	'Wikibase\\LabelDescriptionDuplicateDetector' => __DIR__ . '/includes/LabelDescriptionDuplicateDetector.php',
	'Wikibase\\OutputPageJsConfigBuilder' => __DIR__ . '/includes/OutputPageJsConfigBuilder.php',
	'Wikibase\\PopulateChangesSubscription' => __DIR__ . '/maintenance/populateChangesSubscription.php',
	'Wikibase\\PropertyContent' => __DIR__ . '/includes/Content/PropertyContent.php',
	'Wikibase\\PropertyInfoBuilder' => __DIR__ . '/includes/PropertyInfoBuilder.php',
	'Wikibase\\PruneChanges' => __DIR__ . '/maintenance/pruneChanges.php',
	'Wikibase\\Rdf\\DateTimeValueCleaner' => __DIR__ . '/includes/Rdf/DateTimeValueCleaner.php',
	'Wikibase\\Rdf\\DedupeBag' => __DIR__ . '/includes/Rdf/DedupeBag.php',
	'Wikibase\\Rdf\\DispatchingValueSnakRdfBuilder' => __DIR__ . '/includes/Rdf/DispatchingValueSnakRdfBuilder.php',
	'Wikibase\\Rdf\\EntityMentionListener' => __DIR__ . '/includes/Rdf/EntityMentionListener.php',
	'Wikibase\\Rdf\\EntityRdfBuilder' => __DIR__ . '/includes/Rdf/EntityRdfBuilder.php',
	'Wikibase\\Rdf\\EntityRdfBuilderFactory' => __DIR__ . '/includes/Rdf/EntityRdfBuilderFactory.php',
	'Wikibase\\Rdf\\FullStatementRdfBuilder' => __DIR__ . '/includes/Rdf/FullStatementRdfBuilder.php',
	'Wikibase\\Rdf\\HashDedupeBag' => __DIR__ . '/includes/Rdf/HashDedupeBag.php',
	'Wikibase\\Rdf\\JulianDateTimeValueCleaner' => __DIR__ . '/includes/Rdf/JulianDateTimeValueCleaner.php',
	'Wikibase\\Rdf\\NullDedupeBag' => __DIR__ . '/includes/Rdf/NullDedupeBag.php',
	'Wikibase\\Rdf\\NullEntityMentionListener' => __DIR__ . '/includes/Rdf/NullEntityMentionListener.php',
	'Wikibase\\Rdf\\NullEntityRdfBuilder' => __DIR__ . '/includes/Rdf/NullEntityRdfBuilder.php',
	'Wikibase\\Rdf\\PropertyRdfBuilder' => __DIR__ . '/includes/Rdf/PropertyRdfBuilder.php',
	'Wikibase\\Rdf\\RdfBuilder' => __DIR__ . '/includes/Rdf/RdfBuilder.php',
	'Wikibase\\Rdf\\RdfProducer' => __DIR__ . '/includes/Rdf/RdfProducer.php',
	'Wikibase\\Rdf\\RdfVocabulary' => __DIR__ . '/includes/Rdf/RdfVocabulary.php',
	'Wikibase\\Rdf\\SiteLinksRdfBuilder' => __DIR__ . '/includes/Rdf/SiteLinksRdfBuilder.php',
	'Wikibase\\Rdf\\SnakRdfBuilder' => __DIR__ . '/includes/Rdf/SnakRdfBuilder.php',
	'Wikibase\\Rdf\\TermsRdfBuilder' => __DIR__ . '/includes/Rdf/TermsRdfBuilder.php',
	'Wikibase\\Rdf\\TruthyStatementRdfBuilder' => __DIR__ . '/includes/Rdf/TruthyStatementRdfBuilder.php',
	'Wikibase\\Rdf\\ValueSnakRdfBuilder' => __DIR__ . '/includes/Rdf/ValueSnakRdfBuilder.php',
	'Wikibase\\Rdf\\ValueSnakRdfBuilderFactory' => __DIR__ . '/includes/Rdf/ValueSnakRdfBuilderFactory.php',
	'Wikibase\\Rdf\\Values\\CommonsMediaRdfBuilder' => __DIR__ . '/includes/Rdf/Values/CommonsMediaRdfBuilder.php',
	'Wikibase\\Rdf\\Values\\ComplexValueRdfHelper' => __DIR__ . '/includes/Rdf/Values/ComplexValueRdfHelper.php',
	'Wikibase\\Rdf\\Values\\EntityIdRdfBuilder' => __DIR__ . '/includes/Rdf/Values/EntityIdRdfBuilder.php',
	'Wikibase\\Rdf\\Values\\ExternalIdentifierRdfBuilder' => __DIR__ . '/includes/Rdf/Values/ExternalIdentifierRdfBuilder.php',
	'Wikibase\\Rdf\\Values\\GlobeCoordinateRdfBuilder' => __DIR__ . '/includes/Rdf/Values/GlobeCoordinateRdfBuilder.php',
	'Wikibase\\Rdf\\Values\\LiteralValueRdfBuilder' => __DIR__ . '/includes/Rdf/Values/LiteralValueRdfBuilder.php',
	'Wikibase\\Rdf\\Values\\MonolingualTextRdfBuilder' => __DIR__ . '/includes/Rdf/Values/MonolingualTextRdfBuilder.php',
	'Wikibase\\Rdf\\Values\\ObjectUriRdfBuilder' => __DIR__ . '/includes/Rdf/Values/ObjectUriRdfBuilder.php',
	'Wikibase\\Rdf\\Values\\QuantityRdfBuilder' => __DIR__ . '/includes/Rdf/Values/QuantityRdfBuilder.php',
	'Wikibase\\Rdf\\Values\\TimeRdfBuilder' => __DIR__ . '/includes/Rdf/Values/TimeRdfBuilder.php',
	'Wikibase\\RebuildItemTerms' => __DIR__ . '/maintenance/rebuildItemTerms.php',
	'Wikibase\\RebuildPropertyInfo' => __DIR__ . '/maintenance/rebuildPropertyInfo.php',
	'Wikibase\\RebuildPropertyTerms' => __DIR__ . '/maintenance/rebuildPropertyTerms.php',
	'Wikibase\\RebuildTermSqlIndex' => __DIR__ . '/maintenance/rebuildTermSqlIndex.php',
	'Wikibase\\RebuildTermsSearchKey' => __DIR__ . '/maintenance/rebuildTermsSearchKey.php',
	'Wikibase\\RepoHooks' => __DIR__ . '/RepoHooks.php',
	'Wikibase\\Repo\\ArrayValueCollector' => __DIR__ . '/includes/ArrayValueCollector.php',
	'Wikibase\\Repo\\BabelUserLanguageLookup' => __DIR__ . '/includes/BabelUserLanguageLookup.php',
	'Wikibase\\Repo\\BuilderBasedDataTypeValidatorFactory' => __DIR__ . '/includes/BuilderBasedDataTypeValidatorFactory.php',
	'Wikibase\\Repo\\CachingCommonsMediaFileNameLookup' => __DIR__ . '/includes/CachingCommonsMediaFileNameLookup.php',
	'Wikibase\\Repo\\ChangeDispatcher' => __DIR__ . '/includes/ChangeDispatcher.php',
	'Wikibase\\Repo\\ChangePruner' => __DIR__ . '/includes/ChangePruner.php',
	'Wikibase\\Repo\\Content\\DataUpdateAdapter' => __DIR__ . '/includes/Content/DataUpdateAdapter.php',
	'Wikibase\\Repo\\Content\\EntityContentDiff' => __DIR__ . '/includes/Content/EntityContentDiff.php',
	'Wikibase\\Repo\\Content\\EntityContentFactory' => __DIR__ . '/includes/Content/EntityContentFactory.php',
	'Wikibase\\Repo\\Content\\EntityHandler' => __DIR__ . '/includes/Content/EntityHandler.php',
	'Wikibase\\Repo\\Content\\ItemHandler' => __DIR__ . '/includes/Content/ItemHandler.php',
	'Wikibase\\Repo\\Content\\PropertyHandler' => __DIR__ . '/includes/Content/PropertyHandler.php',
	'Wikibase\\Repo\\DataTypeValidatorFactory' => __DIR__ . '/includes/DataTypeValidatorFactory.php',
	'Wikibase\\Repo\\DispatchingEntityTypeStatementGrouper' => __DIR__ . '/includes/DispatchingEntityTypeStatementGrouper.php',
	'Wikibase\\Repo\\EntityIdHtmlLinkFormatterFactory' => __DIR__ . '/includes/EntityIdHtmlLinkFormatterFactory.php',
	'Wikibase\\Repo\\EntityIdLabelFormatterFactory' => __DIR__ . '/includes/EntityIdLabelFormatterFactory.php',
	'Wikibase\\Repo\\FingerprintSearchTextGenerator' => __DIR__ . '/includes/FingerprintSearchTextGenerator.php',
	'Wikibase\\Repo\\GenericEventDispatcher' => __DIR__ . '/includes/GenericEventDispatcher.php',
	'Wikibase\\Repo\\ItemSearchTextGenerator' => __DIR__ . '/includes/ItemSearchTextGenerator.php',
	'Wikibase\\Repo\\Maintenance\\PopulateTermFullEntityId' => __DIR__ . '/maintenance/populateTermFullEntityId.php',
	'Wikibase\\Repo\\Maintenance\\RebuildItemsPerSite' => __DIR__ . '/maintenance/rebuildItemsPerSite.php',
	'Wikibase\\Repo\\Maintenance\\RemoveTermsInLanguage' => __DIR__ . '/maintenance/removeTermsInLanguage.php',
	'Wikibase\\Repo\\MediaWikiLanguageDirectionalityLookup' => __DIR__ . '/includes/MediaWikiLanguageDirectionalityLookup.php',
	'Wikibase\\Repo\\MediaWikiLocalizedTextProvider' => __DIR__ . '/includes/MediaWikiLocalizedTextProvider.php',
	'Wikibase\\Repo\\PidLock' => __DIR__ . '/includes/PidLock.php',
	'Wikibase\\Repo\\PropertyDataTypeChanger' => __DIR__ . '/includes/PropertyDataTypeChanger.php',
	'Wikibase\\Repo\\RangeTraversable' => __DIR__ . '/includes/RangeTraversable.php',
	'Wikibase\\Repo\\Rdf\\Values\\GeoShapeRdfBuilder' => __DIR__ . '/includes/Rdf/Values/GeoShapeRdfBuilder.php',
	'Wikibase\\Repo\\Rdf\\Values\\TabularDataRdfBuilder' => __DIR__ . '/includes/Rdf/Values/TabularDataRdfBuilder.php',
	'Wikibase\\Repo\\SiteLinkTargetProvider' => __DIR__ . '/includes/SiteLinkTargetProvider.php',
	'Wikibase\\Repo\\SnakFactory' => __DIR__ . '/includes/SnakFactory.php',
	'Wikibase\\Repo\\StatementGrouperBuilder' => __DIR__ . '/includes/StatementGrouperBuilder.php',
	'Wikibase\\Repo\\Store\\ChangeStore' => __DIR__ . '/includes/Store/ChangeStore.php',
	'Wikibase\\Repo\\Store\\DispatchingEntityStoreWatcher' => __DIR__ . '/includes/Store/DispatchingEntityStoreWatcher.php',
	'Wikibase\\Repo\\Store\\EntitiesWithoutTermFinder' => __DIR__ . '/includes/Store/EntitiesWithoutTermFinder.php',
	'Wikibase\\Repo\\Store\\EntityPermissionChecker' => __DIR__ . '/includes/Store/EntityPermissionChecker.php',
	'Wikibase\\Repo\\Store\\EntityTitleStoreLookup' => __DIR__ . '/includes/Store/EntityTitleStoreLookup.php',
	'Wikibase\\Repo\\Store\\ItemTermsRebuilder' => __DIR__ . '/includes/Store/ItemTermsRebuilder.php',
	'Wikibase\\Repo\\Store\\ItemsWithoutSitelinksFinder' => __DIR__ . '/includes/Store/ItemsWithoutSitelinksFinder.php',
	'Wikibase\\Repo\\Store\\PropertyTermsRebuilder' => __DIR__ . '/includes/Store/PropertyTermsRebuilder.php',
	'Wikibase\\Repo\\Store\\SiteLinkConflictLookup' => __DIR__ . '/includes/Store/SiteLinkConflictLookup.php',
	'Wikibase\\Repo\\Store\\Sql\\ChangesSubscriptionSchemaUpdater' => __DIR__ . '/includes/Store/Sql/ChangesSubscriptionSchemaUpdater.php',
	'Wikibase\\Repo\\Store\\Sql\\ChangesSubscriptionTableBuilder' => __DIR__ . '/includes/Store/Sql/ChangesSubscriptionTableBuilder.php',
	'Wikibase\\Repo\\Store\\Sql\\DatabaseSchemaUpdater' => __DIR__ . '/includes/Store/Sql/DatabaseSchemaUpdater.php',
	'Wikibase\\Repo\\Store\\Sql\\DispatchStats' => __DIR__ . '/includes/Store/Sql/DispatchStats.php',
	'Wikibase\\Repo\\Store\\Sql\\ItemsPerSiteBuilder' => __DIR__ . '/includes/Store/Sql/ItemsPerSiteBuilder.php',
	'Wikibase\\Repo\\Store\\Sql\\LockManagerSqlChangeDispatchCoordinator' => __DIR__ . '/includes/Store/Sql/LockManagerSqlChangeDispatchCoordinator.php',
	'Wikibase\\Repo\\Store\\Sql\\PropertyInfoTableBuilder' => __DIR__ . '/includes/Store/Sql/PropertyInfoTableBuilder.php',
	'Wikibase\\Repo\\Store\\Sql\\SqlChangeDispatchCoordinator' => __DIR__ . '/includes/Store/Sql/SqlChangeDispatchCoordinator.php',
	'Wikibase\\Repo\\Store\\Sql\\SqlChangeStore' => __DIR__ . '/includes/Store/Sql/SqlChangeStore.php',
	'Wikibase\\Repo\\Store\\Sql\\SqlEntitiesWithoutTermFinder' => __DIR__ . '/includes/Store/Sql/SqlEntitiesWithoutTermFinder.php',
	'Wikibase\\Repo\\Store\\Sql\\SqlEntityIdPager' => __DIR__ . '/includes/Store/Sql/SqlEntityIdPager.php',
	'Wikibase\\Repo\\Store\\Sql\\SqlEntityIdPagerFactory' => __DIR__ . '/includes/Store/Sql/SqlEntityIdPagerFactory.php',
	'Wikibase\\Repo\\Store\\Sql\\SqlItemsWithoutSitelinksFinder' => __DIR__ . '/includes/Store/Sql/SqlItemsWithoutSitelinksFinder.php',
	'Wikibase\\Repo\\Store\\Sql\\SqlSiteLinkConflictLookup' => __DIR__ . '/includes/Store/Sql/SqlSiteLinkConflictLookup.php',
	'Wikibase\\Repo\\Store\\Sql\\SqlSubscriptionLookup' => __DIR__ . '/includes/Store/Sql/SqlSubscriptionLookup.php',
	'Wikibase\\Repo\\Store\\Sql\\TermSearchKeyBuilder' => __DIR__ . '/includes/Store/Sql/TermSearchKeyBuilder.php',
	'Wikibase\\Repo\\Store\\Sql\\TermSqlIndexBuilder' => __DIR__ . '/includes/Store/Sql/TermSqlIndexBuilder.php',
	'Wikibase\\Repo\\Store\\Sql\\TermSqlIndexSearchFieldsClearer' => __DIR__ . '/includes/Store/Sql/TermSqlIndexSearchFieldsClearer.php',
	'Wikibase\\Repo\\Store\\Sql\\UpsertSqlIdGenerator' => __DIR__ . '/includes/Store/Sql/UpsertSqlIdGenerator.php',
	'Wikibase\\Repo\\Store\\Sql\\WikiPageEntityRedirectLookup' => __DIR__ . '/includes/Store/Sql/WikiPageEntityRedirectLookup.php',
	'Wikibase\\Repo\\Store\\Sql\\WikiPageEntityStore' => __DIR__ . '/includes/Store/Sql/WikiPageEntityStore.php',
	'Wikibase\\Repo\\Store\\TypeDispatchingEntityTitleStoreLookup' => __DIR__ . '/includes/Store/TypeDispatchingEntityTitleStoreLookup.php',
	'Wikibase\\Repo\\Store\\WikiPageEntityStorePermissionChecker' => __DIR__ . '/includes/Store/WikiPageEntityStorePermissionChecker.php',
	'Wikibase\\Repo\\ValidatorBuilders' => __DIR__ . '/includes/ValidatorBuilders.php',
	'Wikibase\\Repo\\ValueParserFactory' => __DIR__ . '/includes/ValueParserFactory.php',
	'Wikibase\\Repo\\WikibaseRepo' => __DIR__ . '/includes/WikibaseRepo.php',
	'Wikibase\\SearchEntities' => __DIR__ . '/maintenance/searchEntities.php',
	'Wikibase\\SqlIdGenerator' => __DIR__ . '/includes/Store/Sql/SqlIdGenerator.php',
	'Wikibase\\SqlStore' => __DIR__ . '/includes/Store/Sql/SqlStore.php',
	'Wikibase\\StatementRankSerializer' => __DIR__ . '/includes/StatementRankSerializer.php',
	'Wikibase\\Store' => __DIR__ . '/includes/Store/Store.php',
	'Wikibase\\StoreFactory' => __DIR__ . '/includes/Store/StoreFactory.php',
	'Wikibase\\Store\\ChangeDispatchCoordinator' => __DIR__ . '/includes/Store/ChangeDispatchCoordinator.php',
	'Wikibase\\Store\\SubscriptionLookup' => __DIR__ . '/includes/Store/SubscriptionLookup.php',
	'Wikibase\\SubmitEntityAction' => __DIR__ . '/includes/Actions/SubmitEntityAction.php',
	'Wikibase\\SummaryFormatter' => __DIR__ . '/includes/SummaryFormatter.php',
	'Wikibase\\Test\\MockAddUnits' => __DIR__ . '/tests/phpunit/maintenance/MockAddUnits.php',
	'Wikibase\\UpdateUnits' => __DIR__ . '/maintenance/updateUnits.php',
	'Wikibase\\ViewEntityAction' => __DIR__ . '/includes/Actions/ViewEntityAction.php',
];
