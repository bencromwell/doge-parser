<?php

namespace Dogs;

use Aura\Sql\ExtendedPdo;
use Aura\SqlQuery\QueryFactory;

class DogeMapper
{

    /** @var ExtendedPdo */
    protected $dbh;

    /**
     * @param ExtendedPdo $dbh
     */
    public function __construct(ExtendedPdo $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @param string $href
     *
     * @return Doge|null
     */
    public function getDogeForHref($href)
    {
        $qf = new QueryFactory('mysql');
        $select = $qf->newSelect();
        $select
            ->cols(['href', 'name', 'imageRef'])
            ->from('doges')
            ->where('href = :href')
            ->bindValue(':href', $href);

        $stmt = $this->dbh->prepare($select->__toString());
        $stmt->execute($select->getBindValues());

        $row = $stmt->fetch();

        if (!empty($row)) {
            return new Doge($row['name'], true, $row['href'], $row['imageRef']);
        }

        return null;
    }

    /**
     * @param Doge $doge
     */
    public function saveDoge(Doge $doge)
    {
        $qf = new QueryFactory('mysql');
        $insert = $qf->newInsert();

        $insert
            ->into('doges')
            ->cols([
                'href', 'name', 'imageRef'
            ])
            ->bindValues([
                ':href'     => $doge->href,
                ':name'     => $doge->name,
                ':imageRef' => $doge->imageHref,
            ]);

        $stmt = $this->dbh->prepare($insert->__toString());
        $stmt->execute($insert->getBindValues());
    }

}
