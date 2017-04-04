<?php

    /**ETML
     *\author  merkya
     *\date    28.03.2017
     *\summary
     */
    class Misc
    {
        /**
         * @param int $type The type of message wanted   0 = Success, 1 = Info, 2 = Warning, default = Error
         * @param string $content
         */
        public static function writeMessage(int $type, string $content)
        {
            echo '<div class="alert ';

            //Choose what type of alert display
            switch ($type) {

                case 0:
                    echo 'alert-success';
                    break;

                case 1:
                    echo 'alert-info';
                    break;

                case 2:
                    echo 'alert-warning';
                    break;

                default:
                    echo 'alert-danger';
                    break;
            }

            echo ' alert-dismissable" >';

            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
            echo '<p>' . $content . '</p>';
            echo '</div>';
        }

    }