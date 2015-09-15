<?php

namespace Destiny\AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DestinyAppBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
