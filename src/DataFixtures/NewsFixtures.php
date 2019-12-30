<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Common\Persistence\ObjectManager;

class NewsFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(News::class, 10,function (News $news, $count) {

        $news->setHeading('News headline')
             ->setAnnotation('News annotation')
             ->setDateCreation(new \DateTime('now'))
             ->setImageName('news1.jpg')
             ->setText(<<<EOF
Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Velit dignissim sodales ut eu sem integer.
Vel turpis nunc eget lorem dolor sed viverra ipsum nunc. Integer
quis auctor elit sed vulputate mi sit. Elementum pulvinar etiam non quam.
Ut ornare lectus sit amet est placerat in egestas. Lectus urna duis convallis
convallis. Viverra nam libero justo laoreet. Scelerisque purus semper eget duis.
Pellentesque habitant morbi tristique senectus et netus et malesuada. Commodo quis
imperdiet massa tincidunt nunc pulvinar sapien. Viverra maecenas accumsan lacus vel. 
A diam sollicitudin tempor id. Faucibus ornare suspendisse sed nisi lacus sed viverra tellus
in. Nibh praesent tristique magna sit amet purus gravida quis. Ipsum a arcu cursus vitae
volutpat blandit. Ut pharetra sit amet aliquam id diam.

Posuere sollicitudin aliquam ultrices sagittis orci.
Purus non enim praesent elementum facilisis leo. Faucibus
ornare suspendisse sed nisi. Scelerisque felis imperdiet 
proin fermentum leo vel orci porta non. Faucibus turpis
in eu mi bibendum neque egestas. Tellus integer feugiat scelerisque 
varius morbi enim nunc. Tortor at risus viverra adipiscing at in tellus 
integer. Dolor purus non enim praesent elementum facilisis leo. Elit eget
gravida cum sociis natoque penatibus. Eget mi proin sed libero enim sed 
faucibus turpis. Feugiat vivamus at augue eget arcu dictum varius duis at. 
Sodales ut etiam sit amet nisl. In vitae turpis massa sed elementum tempus
egestas. Sed elementum tempus egestas sed. Urna porttitor rhoncus dolor purus.
Varius duis at consectetur lorem donec. Tortor condimentum lacinia quis vel eros
donec ac. Quam id leo in vitae. Odio eu feugiat pretium nibh.

Fringilla est ullamcorper eget nulla facilisi etiam dignissim diam. Scelerisque in dictum non
consectetur. Purus sit amet volutpat consequat mauris. Eu ultrices vitae auctor eu augue ut.
Lorem mollis aliquam ut porttitor. Commodo nulla facilisi nullam vehicula. Cras ornare arcu
dui vivamus arcu felis bibendum ut. Augue mauris augue neque gravida in fermentum et sollicitudin 
ac. Commodo nulla facilisi nullam vehicula ipsum a. Magnis dis parturient montes nascetur ridiculus 
mus mauris vitae ultricies. Ornare arcu odio ut sem nulla. Interdum varius sit amet mattis vulputate 
enim nulla aliquet porttitor. Euismod quis viverra nibh cras pulvinar mattis. Lacinia quis vel eros donec
. Facilisis sed odio morbi quis commodo odio aenean sed adipiscing. Pulvinar pellentesque habitant morbi 
tristique senectus et netus et malesuada. Amet mattis vulputate enim nulla aliquet. Eget mauris pharetra
et ultrices. Tortor pretium viverra suspendisse potenti nullam ac tortor vitae.
EOF
            );
        });

        $manager->flush();

    }
}
