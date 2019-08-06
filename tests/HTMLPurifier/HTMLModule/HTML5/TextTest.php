<?php

class HTMLPurifier_HTMLModule_HTML5_TextTest extends BaseTestCase
{
    /**
     * Data provider for {@link testHeaderFooter()}
     * @return array
     */
    public function headerFooterInput()
    {
        return array(
            // Header
            array(
                '<header></header>',
            ),
            array(
                '<header>Foo</header>',
            ),
            array(
                '<header><h1>Foo</h1></header>',
            ),
            array(
                '<div><header></header></div>',
            ),
            array(
                '<span><header></header></span>',
                '<span></span><header></header>',
            ),
            array(
                '<main><header></header></main>',
            ),
            array(
                '<header>Foo<header>Bar</header></header>',
                '<header>Foo</header>',
            ),
            array(
                '<header>Foo<footer>Bar</footer></header>',
                '<header>Foo</header>',
            ),
            array(
                '<header><section>Foo</section></header>',
            ),
            array(
                '<section><header>Foo</header></section>',
            ),

            // Footer
            array(
                '<footer></footer>',
            ),
            array(
                '<footer>Foo</footer>',
            ),
            array(
                '<footer><h1>Foo</h1></footer>',
            ),
            array(
                '<div><footer></footer></div>',
            ),
            array(
                '<span><footer></footer></span>',
                '<span></span><footer></footer>',
            ),
            array(
                '<main><footer></footer></main>',
            ),
            array(
                '<footer>Foo<footer>Bar</footer></footer>',
                '<footer>Foo</footer>',
            ),
            array(
                '<footer>Foo<header>Bar</header></footer>',
                '<footer>Foo</footer>',
            ),
            array(
                '<footer><section>Foo</section></footer>',
            ),
            array(
                '<section><footer>Foo</footer></section>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider headerFooterInput
     */
    public function testHeaderFooter($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    /**
     * Data provider for {@link testMain()}
     * @return array
     */
    public function mainInput()
    {
        return array(
            array(
                '<main></main>',
            ),
            array(
                '<main><main>Foo</main></main>',
            ),
            // Block content
            array(
                '<div><main>Foo</main></div>',
            ),
            // Heading content
            array(
                '<h1><main>Foo</main></h1>',
                '<h1></h1><main>Foo</main>',
            ),
            // Inline content
            array(
                '<span><main>Foo</main></span>',
                '<span></span><main>Foo</main>'
            ),
            // Sectioning content
            array(
                '<section><main>Foo</main></section>',
            ),
            array(
                '<main><section></section></main>',
            ),
            array(
                '<address><main>Foo</main></address>',
            ),
            // Header and footer
            array(
                '<header><main>Foo</main></header>',
                '<header></header>',
            ),
            array(
                '<main><header>Foo</header></main>',
            ),
            array(
                '<main><footer>Foo</footer></main>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider mainInput
     */
    public function testMain($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    /**
     * Data provider for {@link testHeadingContent()}
     * @return array
     */
    public function headingContentInput()
    {
        /** @noinspection HtmlDeprecatedTag */
        return array(
            array(
                '<hgroup><h1>Foo</h1></hgroup>',
            ),
            array(
                '<hgroup><h1></h1></hgroup>',
            ),
            array(
                '<div><hgroup><h1>Foo</h1></hgroup></div>',
            ),
            array(
                '<span><hgroup><h1>Foo</h1></hgroup></span>',
                '<span></span><hgroup><h1>Foo</h1></hgroup>',
            ),
            array(
                '<section><hgroup><h1>Foo</h1></hgroup></section>',
            ),
            array(
                // Element hgroup is missing a required instance of one or more
                // of the following child elements: h1, h2, h3, h4, h5, h6.
                '<hgroup></hgroup>',
                '',
            ),
            array(
                '<hgroup>Foo</hgroup>',
                '',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider headingContentInput
     */
    public function testHeadingContent($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    /**
     * Data provider for {@link testSectioningContent()}
     * @return array
     */
    public function sectioningContentInput()
    {
        return array(
            array(
                '<aside><p>Foo</p></aside>',
            ),
            array(
                '<p><aside></aside></p>',
                '<p></p><aside></aside>',
            ),
            array(
                '<article><p>Foo</p><aside><p>Bar</p></aside><p>Baz</p></article>',
            ),
            array(
                '<nav><ol><li><a href="foo">Foo</a></li></ol></nav>',
            ),
            array(
                '<div><nav>Foo</nav></div>',
            ),
            array(
                // Element nav not allowed as child of element span
                '<span><nav>Foo</nav></span>',
                '<span></span><nav>Foo</nav>',
            ),
            array(
                '<div><nav><ol><li><a href="foo">Foo</a></li></ol></nav></div>',
            ),
            array(
                '<section><nav><ol><li><a href="foo">Foo</a></li></ol></nav></section>',
            ),
            array(
                '<section><h1>Heading</h1><p>Content</p></section>',
            ),
            array(
                '<div><section><h1>Heading</h1><p>Content</p></section></div>',
            ),
            array(
                '<section></section>Foo',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider sectioningContentInput
     */
    public function testSectioningContent($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    /**
     * Data provider for {@link testBlockquote()}
     * @return array
     */
    public function blockquoteInput()
    {
        return array(
            array(
                '<blockquote>Foo</blockquote>',
            ),
            array(
                '<blockquote></blockquote>',
            ),
            array(
                '<blockquote><section>Foo</section></blockquote>',
            ),
            array(
                '<blockquote><nav>Foo</nav></blockquote>',
            ),
            array(
                '<blockquote><h1>Foo</h1></blockquote>',
            ),
            array(
                '<blockquote><p>Foo</p></blockquote>',
            ),
            array(
                '<blockquote><blockquote>Foo</blockquote></blockquote>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider blockquoteInput
     */
    public function testBlockquote($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    /**
     * Data provider for {@link testAddress()}
     * @return array
     */
    public function addressInput()
    {
        return array(
            array(
                '<address><a href="mailto:jim@rock.com">jim@rock.com</a><p><small>© Copyright 2019 ACME Inc.</small></p></address>',
            ),
            array(
                '<address></address>Foo',
            ),
            array(
                '<address><p>Foo</p></address>',
            ),
            array(
                '<address><span>Foo</span></address>',
            ),
            array(
                '<address><div>Foo</div></address>',
            ),
            array(
                '<address><main>Foo</main></address>',
            ),
            array(
                '<address><div><address><p>Foo</p></address></div></address>',
                '<address><div></div></address>',
            ),
            array(
                '<address><h1>Foo</h1></address>',
                '<address></address>',
            ),
            array(
                '<address><header>Foo</header></address>',
                '<address></address>',
            ),
            array(
                '<address>Foo<address><span>Bar</span></address></address>',
                '<address>Foo</address>',
            ),
            array(
                '<section><address>Foo</address></section>',
            ),
            array(
                '<p><address>Foo</address></p>',
                '<p></p><address>Foo</address>',
            ),
            array(
                '<span><address>Foo</address></span>',
                '<span></span><address>Foo</address>',
            ),
        );
    }

     /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider addressInput
     */
    public function testAddress($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function figureInput()
    {
        return array(
            array(
                '<figure><img src="image.png" alt="An awesome picture"><figcaption>Fig.1 Image</figcaption></figure>',
            ),
            array(
                '<figure><figcaption><cite>Someone</cite></figcaption>Something</figure>',
            ),
            array(
                '<figure><p>Something</p><figcaption><cite>Someone</cite></figcaption><p>Something</p></figure>',
                '<figure><p>Something</p><figcaption><cite>Someone</cite></figcaption></figure>',
            ),
            array(
                '<figure><figcaption>Foo</figcaption><figcaption>Bar</figcaption>Baz</figure>',
                '<figure><figcaption>Foo</figcaption>Baz</figure>',
            ),
            'nested figure' => array(
                '<figure><img src="image.png" alt=""><figure><figcaption>Foo</figcaption></figure><figcaption>Bar</figcaption></figure>',
            ),
            'empty figure' => array(
                '<figure></figure>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider figureInput
     */
    public function testFigure($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    /**
     * @dataProvider timeData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testTime($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function timeData()
    {
        return array(
            // valid month
            array('<time>2011-11</time>'),

            // valid date
            array('<time>2011-11-18</time>'),

            // valid yearless date
            array('<time>11-18</time>'),

            // valid time
            array('<time>14:54</time>'),
            array('<time>14:54:39</time>'),
            array('<time>14:54:39.929</time>'),

            // valid local date and time
            array('<time>2011-11-18T14:54</time>'),
            array('<time>2011-11-18T14:54:39</time>'),
            array('<time>2011-11-18T14:54:39.929</time>'),
            array('<time>2011-11-18 14:54</time>'),
            array('<time>2011-11-18 14:54:39</time>'),
            array('<time>2011-11-18 14:54:39.929</time>'),

            // valid time-zone offset
            array('<time>Z</time>'),
            array('<time>-08:00</time>'),
            array('<time>+00:00</time>'),
            array('<time>-0800</time>'),
            array('<time>+0000</time>'),

            // valid global date and time
            array('<time>2011-11-18T14:54Z</time>'),
            array('<time>2011-11-18T14:54:39Z</time>'),
            array('<time>2011-11-18T14:54:39.929Z</time>'),
            array('<time>2011-11-18T14:54+0000</time>'),
            array('<time>2011-11-18T14:54:39+0000</time>'),
            array('<time>2011-11-18T14:54:39.929+0000</time>'),
            array('<time>2011-11-18T14:54+00:00</time>'),
            array('<time>2011-11-18T14:54:39+00:00</time>'),
            array('<time>2011-11-18T14:54:39.929+00:00</time>'),
            array('<time>2011-11-18T06:54-0800</time>'),
            array('<time>2011-11-18T06:54:39-0800</time>'),
            array('<time>2011-11-18T06:54:39.929-0800</time>'),
            array('<time>2011-11-18T06:54-08:00</time>'),
            array('<time>2011-11-18T06:54:39-08:00</time>'),
            array('<time>2011-11-18T06:54:39.929-08:00</time>'),
            array('<time>2011-11-18 14:54Z</time>'),
            array('<time>2011-11-18 14:54:39Z</time>'),
            array('<time>2011-11-18 14:54:39.929Z</time>'),
            array('<time>2011-11-18 14:54+0000</time>'),
            array('<time>2011-11-18 14:54:39+0000</time>'),
            array('<time>2011-11-18 14:54:39.929+0000</time>'),
            array('<time>2011-11-18 14:54+00:00</time>'),
            array('<time>2011-11-18 14:54:39+00:00</time>'),
            array('<time>2011-11-18 14:54:39.929+00:00</time>'),
            array('<time>2011-11-18 06:54-0800</time>'),
            array('<time>2011-11-18 06:54:39-0800</time>'),
            array('<time>2011-11-18 06:54:39.929-0800</time>'),
            array('<time>2011-11-18 06:54-08:00</time>'),
            array('<time>2011-11-18 06:54:39-08:00</time>'),
            array('<time>2011-11-18 06:54:39.929-08:00</time>'),

            // valid week string
            array('<time>2011-W47</time>'),

            // valid year
            array('<time>2011</time>'),
            array('<time>0001</time>'),

            // valid duration
            array('<time>PT4H18M3S</time>'),
            array('<time>4h 18m 3s</time>'),

            // no datetime attribute, invalid datetime contents
            array('<time></time>', '<time datetime="1970-01-01"></time>'),
            array('<time>Foo</time>', '<time datetime="1970-01-01">Foo</time>'),
            array('<time><i>Foo</i></time>', '<time datetime="1970-01-01"><i>Foo</i></time>'),
            array(
                '<time><time>Foo</time></time>',
                '<time datetime="1970-01-01"><time datetime="1970-01-01">Foo</time></time>',
            ),

            // inline
            array('<p>This book was published <time datetime="2014-10"><em>last</em> month</time></p>'),
        );
    }

    /**
     * @dataProvider timeDatetimeData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testTimeDatetime($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function timeDatetimeData()
    {
        return array(
            array('<time datetime="2011-11">Foo</time>'),

            // valid date
            array('<time datetime="2011-11-18">Foo</time>'),

            // valid yearless date
            array('<time datetime="11-18">Foo</time>'),

            // valid time
            array('<time datetime="14:54">Foo</time>'),
            array('<time datetime="14:54:39">Foo</time>'),
            array('<time datetime="14:54:39.929">Foo</time>'),

            // valid local date and time
            array('<time datetime="2011-11-18T14:54">Foo</time>'),
            array('<time datetime="2011-11-18T14:54:39">Foo</time>'),
            array('<time datetime="2011-11-18T14:54:39.929">Foo</time>'),
            array(
                '<time datetime="2011-11-18 14:54">Foo</time>',
                '<time datetime="2011-11-18T14:54">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39">Foo</time>',
                '<time datetime="2011-11-18T14:54:39">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39.929">Foo</time>',
                '<time datetime="2011-11-18T14:54:39.929">Foo</time>',
            ),

            // valid time-zone offset
            array('<time datetime="Z">Foo</time>'),
            array('<time datetime="+00:00">Foo</time>'),
            array('<time datetime="-08:00">Foo</time>'),
            array(
                '<time datetime="+0000">Foo</time>',
                '<time datetime="+00:00">Foo</time>',
            ),
            array(
                '<time datetime="-0800">Foo</time>',
                '<time datetime="-08:00">Foo</time>',
            ),

            // valid global date and time
            array(
                '<time datetime="2011-11-18T14:54Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39.929Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54:39+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39.929+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54:39.929+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39.929+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54:39-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54:39-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54:39.929-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54:39.929-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54:39-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54:39.929-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54Z">Foo</time>',
                '<time datetime="2011-11-18T14:54Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39Z">Foo</time>',
                '<time datetime="2011-11-18T14:54:39Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39.929Z">Foo</time>',
                '<time datetime="2011-11-18T14:54:39.929Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54:39+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39.929+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54:39.929+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54+00:00">Foo</time>',
                '<time datetime="2011-11-18T14:54+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39+00:00">Foo</time>',
                '<time datetime="2011-11-18T14:54:39+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39.929+00:00">Foo</time>',
                '<time datetime="2011-11-18T14:54:39.929+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54:39-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54:39-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54:39.929-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54:39.929-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54-08:00">Foo</time>',
                '<time datetime="2011-11-18T06:54-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54:39-08:00">Foo</time>',
                '<time datetime="2011-11-18T06:54:39-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54:39.929-08:00">Foo</time>',
                '<time datetime="2011-11-18T06:54:39.929-08:00">Foo</time>',
            ),

            // valid week string
            array('<time datetime="2011-W47">Foo</time>'),

            // valid year
            array('<time datetime="2011">Foo</time>'),
            array('<time datetime="0001">Foo</time>'),

            // valid duration
            array('<time datetime="PT4H18M3S">Foo</time>'),
            array('<time datetime="4h 18m 3s">Foo</time>'),

            // time with inline elements
            array('<time datetime="Z"><i>UTC</i></time>'),

            // invalid datetime - use UNIX epoch instead of removing <time> element
            array(
                '<time datetime=""></time>',
                '<time datetime="1970-01-01"></time>',
            ),
            array(
                '<time datetime="">Foo</time>',
                '<time datetime="1970-01-01">Foo</time>',
            ),
            array(
                '<time datetime="10">Foo</time>',
                '<time datetime="1970-01-01">Foo</time>',
            ),
            array(
                '<time datetime="Foo">Foo</time>',
                '<time datetime="1970-01-01">Foo</time>',
            ),
        );
    }
}
