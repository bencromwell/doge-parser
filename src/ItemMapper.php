<?php

namespace Parser;

use Aura\Sql\ExtendedPdo;
use Aura\SqlQuery\QueryFactory;

class ItemMapper
{

    /** @var ExtendedPdo */
    protected $dbh;

    /** @var string */
    protected $instance;

    /**
     * @param ExtendedPdo $dbh
     */
    public function __construct(ExtendedPdo $dbh, $instance)
    {
        $this->dbh = $dbh;
        $this->instance = $instance;
    }

    /**
     * @param string $href
     *
     * @return Item|null
     */
    public function getItemForHref($href)
    {
        $qf = new QueryFactory('mysql');
        $select = $qf->newSelect();
        $select
            ->cols(['href', 'name', 'imageRef'])
            ->from('items')
            ->where('href = :href')
            ->where('instance = :instance')
            ->bindValue(':href', $href)
            ->bindValue(':instance', $this->instance);

        $stmt = $this->dbh->prepare($select->__toString());
        $stmt->execute($select->getBindValues());

        $row = $stmt->fetch();

        if (!empty($row)) {
            return new Item($row['name'], $row['href'], $row['imageRef']);
        }

        return null;
    }

    /**
     * @param Item $item
     */
    public function saveItem(Item $item)
    {
        $qf = new QueryFactory('mysql');
        $insert = $qf->newInsert();

        $insert
            ->into('items')
            ->cols([
                'instance', 'href', 'name', 'imageRef'
            ])
            ->bindValues([
                ':instance' => $this->instance,
                ':href' => $item->href,
                ':name' => $item->name,
                ':imageRef' => $item->imageHref,
            ]);

        $stmt = $this->dbh->prepare($insert->__toString());
        $stmt->execute($insert->getBindValues());
    }

}
