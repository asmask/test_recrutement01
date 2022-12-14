<?php

namespace App\Test\Controller;

use App\Entity\Facture;
use App\Repository\FactureRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FactureControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FactureRepository $repository;
    private string $path = '/facture/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Facture::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Facture index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'facture[designation]' => 'Testing',
            'facture[description]' => 'Testing',
            'facture[prixHT]' => 'Testing',
            'facture[prixTTC]' => 'Testing',
        ]);

        self::assertResponseRedirects('/facture/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Facture();
        $fixture->setDesignation('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrixHT('My Title');
        $fixture->setPrixTTC('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Facture');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Facture();
        $fixture->setDesignation('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrixHT('My Title');
        $fixture->setPrixTTC('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'facture[designation]' => 'Something New',
            'facture[description]' => 'Something New',
            'facture[prixHT]' => 'Something New',
            'facture[prixTTC]' => 'Something New',
        ]);

        self::assertResponseRedirects('/facture/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDesignation());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getPrixHT());
        self::assertSame('Something New', $fixture[0]->getPrixTTC());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Facture();
        $fixture->setDesignation('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrixHT('My Title');
        $fixture->setPrixTTC('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/facture/');
    }
}
