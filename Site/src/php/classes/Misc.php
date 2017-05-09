<?php

    /*
         ETML
         Auteur: Yann Merk
         Date: 28.03.17
         Description: Class permettant l'affichage d'erreur sur une page
     */

    class Misc
    {
        /**
         * @param int $type Le type de message voulue 0 = R�ussi, 1 = Info, 2 = Attention, d�faut = erreur
         * @param string $content Contenu du message
         */
        public static function writeMessage(int $type, string $content)
        {
            echo '<div class="alert ';

            //Choisi quel type d'alert � afficher
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