<?php

namespace App\Test\Controller;

use App\Entity\Reclamation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReclamationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/reclamation/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Reclamation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Reclamation ');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'reclamation[descr]' => 'Testing',
            'reclamation[nomr]' => 'Testing',
            'reclamation[emailr]' => 'Testing',
            'reclamation[type]' => 'Testing',
            'reclamation[idu]' => 'Testing',
            'reclamation[idb]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reclamation();
        $fixture->setDescr('My Title');
        $fixture->setNomr('My Title');
        $fixture->setEmailr('My Title');
        $fixture->setType('My Title');
        $fixture->setIdu('My Title');
        $fixture->setIdb('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Reclamation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reclamation();
        $fixture->setDescr('Value');
        $fixture->setNomr('Value');
        $fixture->setEmailr('Value');
        $fixture->setType('Value');
        $fixture->setIdu('Value');
        $fixture->setIdb('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'reclamation[descr]' => 'Something New',
            'reclamation[nomr]' => 'Something New',
            'reclamation[emailr]' => 'Something New',
            'reclamation[type]' => 'Something New',
            'reclamation[idu]' => 'Something New',
            'reclamation[idb]' => 'Something New',
        ]);

        self::assertResponseRedirects('/reclamation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDescr());
        self::assertSame('Something New', $fixture[0]->getNomr());
        self::assertSame('Something New', $fixture[0]->getEmailr());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getIdu());
        self::assertSame('Something New', $fixture[0]->getIdb());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reclamation();
        $fixture->setDescr('Value');
        $fixture->setNomr('Value');
        $fixture->setEmailr('Value');
        $fixture->setType('Value');
        $fixture->setIdu('Value');
        $fixture->setIdb('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/reclamation/');
        self::assertSame(0, $this->repository->count([]));
    }
}
