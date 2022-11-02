<?php

namespace App\Entity;

enum Status
{
	case Draft;
	case Published;
	case Archived;
}

function acceptStatus(Status $status) {

}
