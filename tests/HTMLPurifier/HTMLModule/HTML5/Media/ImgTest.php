<?php

class HTMLPurifier_HTMLModule_HTML5_Media_ImgTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            array(
                '<img src="image-src.png" srcset="image-1x.png 1x, image-2x.png 2x" sizes="(min-width: 640px) 480px" alt="">',
            ),
            array(
                '<img src="2.jpeg" loading="eager" alt="2"><img src="3.jpeg" loading="lazy" alt="3">',
            ),
        );
    }
}
