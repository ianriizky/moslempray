<?php

namespace Ianrizky\MoslemPray\Contracts\Response;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * @method \Ianrizky\MoslemPray\Contracts\Response\HasPrayerTime current()
 */
interface HasPrayerTimeCollection extends ArrayAccess, Iterator, Countable, Responsable
{
    //
}
