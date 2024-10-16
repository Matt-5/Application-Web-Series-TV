<?php

declare(strict_types=1);

namespace Tests\Crud;

use Entity\Exception\EntityNotFoundException;
use Entity\TvShow;
use Tests\CrudTester;

class TvShowCest
{
    public function findById(CrudTester $I)
    {
        $tvShow = TvShow::findById(57);
        $I->assertSame(57, $tvShow->getId());
        $I->assertSame('Good Omens', $tvShow->getName());
        $I->assertSame('Good Omens', $tvShow->getOriginalName());
        $I->assertSame('https://www.amazon.com/dp/B07FMHTRFF', $tvShow->getHomepage());
        $I->assertSame('Suit les aventures de Crowley et Aziraphale, un démon et un ange, qui décident de saborder l’Apocalypse car ils se sont trop habitués à la vie sur Terre.', $tvShow->getOverview());
        $I->assertSame(466, $tvShow->getPosterId());
    }

    public function findByIdThrowsExceptionIfArtistDoesNotExist(CrudTester $I)
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            TvShow::findById(PHP_INT_MAX);
        });
    }

    public function delete(CrudTester $I)
    {
        $tvShow = TvShow::findById(57);
        $tvShow->delete();
        $I->cantSeeInDatabase('tvshow', ['id' => 57]);
        $I->cantSeeInDatabase('tvshow', ['name' => 'Good Omens']);
        $I->cantSeeInDatabase('tvshow', ['originalName' => 'Good Omens']);
        $I->cantSeeInDatabase('tvshow', ['homepage' => 'https://www.amazon.com/dp/B07FMHTRFF']);
        $I->cantSeeInDatabase('tvshow', ['overview' => 'Suit les aventures de Crowley et Aziraphale, un démon et un ange, qui décident de saborder l’Apocalypse car ils se sont trop habitués à la vie sur Terre.']);
        $I->cantSeeInDatabase('tvshow', ['posterId' => 466]);
        $I->assertNull($tvShow->getId());
        $I->assertSame('Good Omens', $tvShow->getName());
        $I->assertSame('Good Omens', $tvShow->getOriginalName());
        $I->assertSame('https://www.amazon.com/dp/B07FMHTRFF', $tvShow->getHomepage());
        $I->assertSame('Suit les aventures de Crowley et Aziraphale, un démon et un ange, qui décident de saborder l’Apocalypse car ils se sont trop habitués à la vie sur Terre.', $tvShow->getOverview());
        $I->assertSame(466, $tvShow->getPosterId());
    }

    public function update(CrudTester $I)
    {
        $tvShow = TvShow::findById(57);
        $tvShow->setName('Noeud Coulant');
        $tvShow->setOriginalName('Noeud Coulant');
        $tvShow->setHomepage('https://iut-info.univ-reims.fr');
        $tvShow->setOverview('Noeud Coulant');
        $tvShow->setPosterId(null);
        $tvShow->save();
        $I->canSeeNumRecords(1, 'tvshow', [
            'id' => 57,
            'name' => 'Noeud Coulant',
            'originalName' => 'Noeud Coulant',
            'homepage' => 'https://iut-info.univ-reims.fr',
            'overview' => 'Noeud Coulant',
            'posterId' => null
        ]);
        $I->assertSame(57, $tvShow->getId());
        $I->assertSame('Noeud Coulant', $tvShow->getName());
        $I->assertSame('Noeud Coulant', $tvShow->getOriginalName());
        $I->assertSame('https://iut-info.univ-reims.fr', $tvShow->getHomepage());
        $I->assertSame('Noeud Coulant', $tvShow->getOverview());
        $I->assertSame(null, $tvShow->getPosterId());
    }

    public function createWithoutId(CrudTester $I)
    {
        $tvShow = TvShow::create('Nœud Coulant', 'Nœud Coulant', 'https://iut-info.univ-reims.fr', 'Nœud Coulant');
        $I->assertNull($tvShow->getId());
        $I->assertNull($tvShow->getPosterId());
        $I->assertSame('Nœud Coulant', $tvShow->getName());
        $I->assertSame('Nœud Coulant', $tvShow->getOriginalName());
        $I->assertSame('https://iut-info.univ-reims.fr', $tvShow->getHomepage());
        $I->assertSame('Nœud Coulant', $tvShow->getOverview());
    }

    public function createWithId(CrudTester $I)
    {
        $tvShow = TvShow::create('Nœud Coulant', 'Nœud Coulant', 'https://iut-info.univ-reims.fr', 'Nœud Coulant', 4);
        $I->assertSame(4, $tvShow->getId());
        $I->assertNull($tvShow->getPosterId());
        $I->assertSame('Nœud Coulant', $tvShow->getName());
        $I->assertSame('Nœud Coulant', $tvShow->getOriginalName());
        $I->assertSame('https://iut-info.univ-reims.fr', $tvShow->getHomepage());
        $I->assertSame('Nœud Coulant', $tvShow->getOverview());
    }

    public function createWithPosterId(CrudTester $I)
    {
        $tvShow = TvShow::create('Nœud Coulant', 'Nœud Coulant', 'https://iut-info.univ-reims.fr', 'Nœud Coulant', 4, 16);
        $I->assertSame(4, $tvShow->getId());
        $I->assertSame('Nœud Coulant', $tvShow->getName());
        $I->assertSame('Nœud Coulant', $tvShow->getOriginalName());
        $I->assertSame('https://iut-info.univ-reims.fr', $tvShow->getHomepage());
        $I->assertSame('Nœud Coulant', $tvShow->getOverview());
        $I->assertSame(16, $tvShow->getPosterId());
    }

    /**
     * @after createWithoutId
     */
    public function insert(CrudTester $I)
    {
        $tvShow = TvShow::create('Nœud Coulant', 'Nœud Coulant', 'https://iut-info.univ-reims.fr', 'Nœud Coulant');
        $tvShow->save();
        $I->canSeeNumRecords(1, 'tvshow', [
            'id' => 83,
            'name' => 'Nœud Coulant',
            'originalName' => 'Nœud Coulant',
            'homepage' => 'https://iut-info.univ-reims.fr',
            'overview' => 'Nœud Coulant'
        ]);
        $I->assertSame($tvShow->getId(), 83);
        $I->assertSame('Nœud Coulant', $tvShow->getName());
        $I->assertSame('Nœud Coulant', $tvShow->getOriginalName());
        $I->assertSame('https://iut-info.univ-reims.fr', $tvShow->getHomepage());
        $I->assertSame('Nœud Coulant', $tvShow->getOverview());
    }
}
