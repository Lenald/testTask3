<?php

class Parser
{
    private $team = "";
    private $seasons = [];

    private function retrieveSeasonsLinks()
    {
        $html = file_get_html('https://terrikon.com/football/italy/championship/archive');

        foreach($html->find('.maincol .news a') as $element) {
            $season = substr($element->plaintext, 0, 7);
            $this->seasons[$season]['link'] = 'https://terrikon.com' . $element->href;
        }

    }

    private function parseSeasons() {

        foreach ($this->seasons as $season => $link) {
            $html = file_get_html($link['link']);

            foreach ($html->find('.maincol .colored.big tr') as $tr) {
                if ($tr->find('th')) {
                    continue;
                }
                $td = $tr->find('td');
                $position = (int) $td[0]->plaintext;
                $team = $td[1]->plaintext;

                $this->seasons[$season][$team] = $position;

            }
        }
    }

    private function printTeamPositions()
    {
        echo "Команда {$this->team}:
        <table border=1>
            <tr>
                <th>Сезон</th>
                <th>Позиция</th>
            </tr>";
        foreach ($this->seasons as $season => $info) {
            $position = (isset($info[$this->team])) ? $info[$this->team] : 'Нет информации';
            echo "<tr>
                <td>$season</td>
                <td>$position</td>
            </tr>";
        }
        echo "</table>";
    }

    public function run(string $team)
    {
        $this->team = $team;
        $this->retrieveSeasonsLinks();
        $this->parseSeasons();
        $this->printTeamPositions();
    }

}