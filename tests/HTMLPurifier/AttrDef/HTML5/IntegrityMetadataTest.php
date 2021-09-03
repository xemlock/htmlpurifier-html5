<?php

/**
 * @property HTMLPurifier_AttrDef_HTML5_IntegrityMetadata $attr
 */
class HTMLPurifier_AttrDef_HTML5_IntegrityMetadataTest extends AttrDefTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->attr = new HTMLPurifier_AttrDef_HTML5_IntegrityMetadata();
    }

    /**
     * @dataProvider dataProvider
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testDataProvider($input, $expected = null)
    {
        $this->assertValidate($input, $expected);
    }

    public function dataProvider()
    {
        return array(
            // valid values
            array(
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY='
            ),
            array(
                'sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO'
            ),
            array(
                'sha512-Q2bFTOhEALkN8hOms2FKTDLy7eugP2zFZ1T8LCvX42Fp3WoNr3bjZSAHeOsHrbV1Fu9/A0EzCinRE7Af1ofPrw=='
            ),

            // valid without padding
            array(
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY',
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY='
            ),
            array(
                'sha512-Q2bFTOhEALkN8hOms2FKTDLy7eugP2zFZ1T8LCvX42Fp3WoNr3bjZSAHeOsHrbV1Fu9/A0EzCinRE7Af1ofPrw',
                'sha512-Q2bFTOhEALkN8hOms2FKTDLy7eugP2zFZ1T8LCvX42Fp3WoNr3bjZSAHeOsHrbV1Fu9/A0EzCinRE7Af1ofPrw=='
            ),

            // valid multiple
            array(
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO sha512-Q2bFTOhEALkN8hOms2FKTDLy7eugP2zFZ1T8LCvX42Fp3WoNr3bjZSAHeOsHrbV1Fu9/A0EzCinRE7Af1ofPrw=='
            ),
            array(
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO sha512-Q2bFTOhEALkN8hOms2FKTDLy7eugP2zFZ1T8LCvX42Fp3WoNr3bjZSAHeOsHrbV1Fu9/A0EzCinRE7Af1ofPrw',
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO sha512-Q2bFTOhEALkN8hOms2FKTDLy7eugP2zFZ1T8LCvX42Fp3WoNr3bjZSAHeOsHrbV1Fu9/A0EzCinRE7Af1ofPrw=='
            ),

            // invalid
            'invalid format' => array('foo-bar', false),
            'invalid length' => array('sha256-ymsp1QFc', false),
            'invalid characters' => array('sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5-_QY=', false),

            // mixed valid & invalid
            array(
                'sha256-fooBar sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO',
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO',
            ),
            array(
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha256-fooBar sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO',
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO',
            ),
            array(
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO sha256-fooBar',
                'sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO',
            ),
        );
    }
}
