<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2022 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Fisharebest\Webtrees\Module;

use Fisharebest\Localization\Locale\LocaleFr;
use Fisharebest\Localization\Locale\LocaleInterface;
use Fisharebest\Webtrees\Relationship;

/**
 * Class LanguageFrench.
 */
class LanguageFrench extends AbstractModule implements ModuleLanguageInterface
{
    use ModuleLanguageTrait;

    protected const SYMMETRIC_COUSINS = [
        1 => [
            'F' => ['cousine germaine', '%s de la cousine germaine'],
            'M' => ['cousin germain', '%s du cousin germain'],
            'U' => ['cousin germain', '%s du cousin germain']
        ],
        2 => [
            'F' => ['cousine issue de germain', '%s de la cousine issue de germain'],
            'M' => ['cousin issu de germain', '%s du cousin issu de germain'],
            'U' => ['cousin issu de germain', '%s du cousin issu de germain']
        ]
    ];

    protected const ASYMMETRIC_COUSINS = [
        1 => [
            'F' => ['down', 'petite-cousine', 'de la '],
            'M' => ['down', 'petit-cousin', 'du '],
            'U' => ['down', 'petit-cousin', 'du ']
        ],
        -1 => [
            'F' => ['up', 'grand-cousine', 'de la '],
            'M' => ['up', 'grand-cousin', 'du '],
            'U' => ['up', 'grand-cousin', 'du ']
        ],
    ];

    /**
     * @return LocaleInterface
     */
    public function locale(): LocaleInterface
    {
        return new LocaleFr();
    }

    /**
     * Pour les traducteurs fran??ais, certaines configurations peuvent avoir plusieurs traduction fran??aises possibles,
     * ou aucune. Voici les choix qui ont ??t?? faits (mais compl??tement ouverts ?? discussion):
     *
     * - je n'ai aucune intention de rentrer dans le d??bat de l'??criture inclusive, mais malheureusement un choix doit
     *   ??tre fait: lorsque n??cessaire dans les choix des articles ou accords, je m'en suis tenu ?? la recommandation de
     *   l'Acad??mie Fran??aise d'utiliser la forme non marqu??e (et donc le masculin) pour le genre neutre.
     * - dans le cas de fr??res/s??urs jumeaux, j'??vite le probl??me en utiliseant le substantif `jumeau` lorsque le sexe
     *   n'est pas connu, alors que j'utilise la structure `fr??re jumeau`/`s??ur jumelle` lorsque le sexe est connu.
     * - `conjoint` a ??t?? choisi pour un couple non mari?? (`??poux`/`??pouse` lorsque les conjoints sont mari??s).
     *   Une alternative est `partenaire`, mais `conjoint` est le terme d??j?? utilis?? dans les traductions fran??aises.
     * - la notion de `foster` (qui peut traduire plusieurs r??alit??s diff??rentes en fran??ais) a ??t?? traduite dans le
     *   cadre de la `famille d'accueil`. Les suggestions sont les bienvenues.
     * - La situation des enfants dans les familles recompos??es a ??t?? traduite:
     *      - `fr??re`/`s??ur` pour les enfants dont les deux parents sont les m??mes
     *      - `demi-fr??re`/`demi-s??ur` pour les enfants qui ont un parent en commun
     *      - `quasi-fr??re`/`quasi-s??ur` pour les enfants qui ne partagent aucun parent en commun, mais dont les parents
     *      sont en couple
     * - la notion d'??ge entre fr??res/s??urs a ??t?? traduite par `grand fr??re`/`petit fr??re`, plut??t que des variantes sur
     *   `fr??re a??n??`/`fr??re cadet` ou `fr??re plus ??g??`/`fr??re plus jeune`
     * - Lorsqu'il est n??cessaire d'aller au-del?? d'un `arri??re-`{substantif} (par exemple, pour d??crire le case de
     *   l'enfant d'un arri??re-petit-enfant), la forme `{substantif} au Ne degr??` est choisie, avec pour convention
     *   N = 1 pour le niveau du substantif racine, on utilisera donc par exemple:
     *      - `petit-enfant` (= petit-enfant au 1er degr??)
     *      - `arri??re-petit-enfant` (= petit-enfant au 2e degr??)
     *      - `petit-enfant au 3e degr??` et ainsi de suite pour les degr??s sup??rieurs
     * - Un exception ?? la r??gle pr??c??dente sont les grand-parents au 3e degr??, qui ont la description de `trisa??eux`.
     * - Pour les cousins, c'est la description selon le droit canon qui a ??t?? choisie (principalement car elle donne
     *   une meilleure visibilit?? de la distance ?? l'anc??tre commun que la description en droit civil), donc:
     *      - l'enfant d'un oncle/tante est un `cousin germain`/`cousine germaine` (= cousins au 1er degr??)
     *      - les enfants de cousins germains sont des `cousins issus de germain` (= cousins au 2e degr??)
     *      - pour les enfants des cousins issus de germains, et ainsi de suite, la relation est d??crite suivant le
     *      nombre de degr?? s??parant les cousins de l'anc??tre commun:
     *      - en cas de sym??trie des chemins, ils sont dits `cousins au N-??me degr??`
     *      - en cas d'asym??trie des chemins, ils sont dit  `cousins du N-??me au M-??me degr??`
     *      - de plus, les notions de `grand-cousin` et `petit-cousin` ont ??t?? impl??ment??es comme suit:
     *          - un `(arri??re-)grand-cousin` est l'enfant d'un `(arri??re-)grand-oncle`/`grand-tante`
     *              (= cousin du 1er au N-??me degr??)
     *          - un `(arri??re-)petit-cousin` est un `(arri??re-)petit-neveu`/`petite-ni??ce` d'un parent
     *              (= cousin du Ner au 1er degr??)
     *
     * @return array<Relationship>
     */
    public function relationships(): array
    {
        // Construct the genitive form in French
        $genitive = static fn (string $s, string $genitive_link): array => [$s, '%s ' . $genitive_link . $s];

        // Functions to coumpound the name that can be indefinitely repeated
        $degree = static fn (int $n, string $suffix, string $genitive_link): array =>
                $genitive($suffix . ' au ' . $n . '<sup>e</sup> degr??', $genitive_link);

        $great = static fn (int $n, string $suffix, string $genitive_link): array =>
                $n <= 1 ? $genitive('arri??re-' . $suffix, 'de l???') : $degree($n + 1, $suffix, $genitive_link);

        $firstCompound = static fn (int $n, string $suffix, string $genitive_link): array =>
                $n <= 1 ? $genitive($suffix, $genitive_link) : $great($n - 1, $suffix, $genitive_link);

        $compound =
            static fn (int $n, string $first_level, string $suffix, string $genitive_none, string $genitive_first): array =>
                $n <= 1 ? $genitive($suffix, $genitive_none) : $firstCompound($n - 1, $first_level . $suffix, $genitive_first);

        // Functions to translate cousins' degree of relationship
        $symmetricCousin = static fn (int $n, string $sex): array => self::SYMMETRIC_COUSINS[$n][$sex] ?? $genitive(
            $sex === 'F' ? 'cousine au ' . $n . '<sup>e</sup> degr??' : 'cousin au ' . $n . '<sup>e</sup> degr??',
            $sex === 'F' ? 'de la ' : 'du '
        );

        $cousin =
            static function (int $up, int $down, string $sex) use ($symmetricCousin, $firstCompound, $genitive): array {
                if ($up === $down) {
                    return $symmetricCousin($up, $sex);
                }
                $fixed = self::ASYMMETRIC_COUSINS[$up][$sex] ?? self::ASYMMETRIC_COUSINS[-$down][$sex] ?? null;
                if ($fixed !== null) {
                    $fixed[0] = $fixed[0] === 'up' ? $up - 1 : $down - 1;
                    return $firstCompound(...$fixed);
                }
                return $genitive(
                    $sex === 'F' ?
                        'cousine du ' . $down . '<sup>e</sup> au ' . $up . '<sup>e</sup> degr??' :
                        'cousin du ' . $down . '<sup>e</sup> au ' . $up . '<sup>e</sup> degr??',
                    $sex === 'F' ? 'de la ' : 'du '
                );
            };

        return [
            // Adopted
            Relationship::fixed('m??re adoptive', '%s de la m??re adoptive')->adoptive()->mother(),
            Relationship::fixed('p??re adoptif', '%s du p??re adoptif')->adoptive()->father(),
            Relationship::fixed('parent adoptif', '%s du parent adoptif')->adoptive()->parent(),
            Relationship::fixed('s??ur adoptive', '%s de la s??ur adoptive')->adoptive()->sister(),
            Relationship::fixed('fr??re adoptif', '%s du fr??re adoptif')->adoptive()->brother(),
            Relationship::fixed('fr??re/s??ur adoptif', '%s du fr??re/s??ur adoptif')->adoptive()->sibling(),
            Relationship::fixed('fille adoptive', '%s de la fille adoptive')->adopted()->daughter(),
            Relationship::fixed('fils adoptif', '%s du fils adoptif')->adopted()->son(),
            Relationship::fixed('enfant adoptif', '%s de l???enfant adoptif')->adopted()->child(),
            Relationship::fixed('s??ur adoptive', '%s de la s??ur adoptive')->adopted()->sister(),
            Relationship::fixed('fr??re adoptif', '%s du fr??re adoptif')->adopted()->brother(),
            Relationship::fixed('fr??re/s??ur adoptif', '%s du fr??re/s??ur adoptif')->adopted()->sibling(),
            // Fostered
            Relationship::fixed('m??re d???accueil', '%s de la m??re d???acceuil')->fostering()->mother(),
            Relationship::fixed('p??re d???accueil', '%s du p??re d???acceuil')->fostering()->father(),
            Relationship::fixed('parent d???accueil', '%s du parent d???acceuil')->fostering()->parent(),
            Relationship::fixed('s??ur d???accueil', '%s de la s??ur d???accueil')->fostering()->sister(),
            Relationship::fixed('fr??re d???accueil', '%s du fr??re d???accueil')->fostering()->brother(),
            Relationship::fixed('fr??re/s??ur d???accueil', '%s du fr??re/s??ur d???accueil')->fostering()->sibling(),
            Relationship::fixed('fille accueillie', '%s de la fille accueillie')->fostered()->daughter(),
            Relationship::fixed('fils accueilli', '%s du fils accueilli')->fostered()->son(),
            Relationship::fixed('enfant accueilli', '%s de l???enfant accueilli')->fostered()->child(),
            Relationship::fixed('s??ur accueillie', '%s de la s??ur accueillie')->fostered()->sister(),
            Relationship::fixed('fr??re accueilli', '%s du fr??re accueilli')->fostered()->brother(),
            Relationship::fixed('fr??re/s??ur accueilli', '%s du fr??re/s??ur accueilli')->fostered()->sibling(),
            // Parents
            Relationship::fixed('m??re', '%s de la m??re')->mother(),
            Relationship::fixed('p??re', '%s du p??re')->father(),
            Relationship::fixed('parent', '%s du parent')->parent(),
            // Children
            Relationship::fixed('fille', '%s de la fille')->daughter(),
            Relationship::fixed('fils', '%s du fils')->son(),
            Relationship::fixed('enfant', '%s de l???enfant')->child(),
            // Siblings
            Relationship::fixed('s??ur jumelle', '%s de la s??ur jumelle')->twin()->sister(),
            Relationship::fixed('fr??re jumeau', '%s du fr??re jumeau')->twin()->brother(),
            Relationship::fixed('jumeau', '%s du jumeau')->twin()->sibling(),
            Relationship::fixed('grande s??ur', '%s de la grande s??ur')->older()->sister(),
            Relationship::fixed('grand fr??re', '%s du grand fr??re')->older()->brother(),
            Relationship::fixed('grand fr??re/s??ur', '%s du grand fr??re/s??ur')->older()->sibling(),
            Relationship::fixed('petite s??ur', '%s de la petite s??ur')->younger()->sister(),
            Relationship::fixed('petit fr??re', '%s du petit-fr??re')->younger()->brother(),
            Relationship::fixed('petit fr??re/s??ur', '%s du petit fr??re/s??ur')->younger()->sibling(),
            Relationship::fixed('s??ur', '%s de la s??ur')->sister(),
            Relationship::fixed('fr??re', '%s du fr??re')->brother(),
            Relationship::fixed('fr??re/s??ur', '%s du fr??re/s??ur')->sibling(),
            // Half-family
            Relationship::fixed('demi-s??ur', '%s de la demi-s??ur')->parent()->daughter(),
            Relationship::fixed('demi-fr??re', '%s du demi-fr??re')->parent()->son(),
            Relationship::fixed('demi-fr??re/s??ur', '%s du demi-fr??re/s??ur')->parent()->child(),
            // Stepfamily
            Relationship::fixed('belle-m??re', '%s de la belle-m??re')->parent()->wife(),
            Relationship::fixed('beau-p??re', '%s du beau-p??re')->parent()->husband(),
            Relationship::fixed('beau-parent', '%s du beau-parent')->parent()->married()->spouse(),
            Relationship::fixed('belle-fille', '%s de la belle-fille')->married()->spouse()->daughter(),
            Relationship::fixed('beau-fils', '%s du beau-fils')->married()->spouse()->son(),
            Relationship::fixed('beau-fils/fille', '%s du beau-fils/fille')->married()->spouse()->child(),
            Relationship::fixed('quasi-s??ur', '%s de la quasi-s??ur')->parent()->spouse()->daughter(),
            Relationship::fixed('quasi-fr??re', '%s du quasi-fr??re')->parent()->spouse()->son(),
            Relationship::fixed('quasi-fr??re/s??ur', '%s du quasi-fr??re/s??ur')->parent()->spouse()->child(),
            // Partners
            Relationship::fixed('ex-??pouse', '%s de l???ex-??pouse')->divorced()->partner()->female(),
            Relationship::fixed('ex-??poux', '%s de l???ex-??poux')->divorced()->partner()->male(),
            Relationship::fixed('ex-??poux', '%s de l???ex-??poux')->divorced()->partner(),
            Relationship::fixed('ex-conjointe', '%s de l???ex-conjoint')->divorced()->partner()->female(),
            Relationship::fixed('ex-conjoint', '%s de l???ex-conjoint')->divorced()->partner()->male(),
            Relationship::fixed('ex-conjoint', '%s de l???ex-conjoint')->divorced()->partner(),
            Relationship::fixed('fianc??e', '%s de la fianc??e')->engaged()->partner()->female(),
            Relationship::fixed('fianc??', '%s du fianc??')->engaged()->partner()->male(),
            Relationship::fixed('??pouse', '%s de l?????pouse')->wife(),
            Relationship::fixed('??poux', '%s de l?????poux')->husband(),
            Relationship::fixed('??poux', '%s de l?????poux')->spouse(),
            Relationship::fixed('conjointe', '%s du conjoint')->partner()->female(),
            Relationship::fixed('conjoint', '%s du conjoint')->partner()->male(),
            Relationship::fixed('conjoint', '%s du conjoint')->partner(),
            // In-laws
            Relationship::fixed('belle-m??re', '%s de la belle-m??re')->married()->spouse()->mother(),
            Relationship::fixed('beau-p??re', '%s du beau-p??re')->married()->spouse()->father(),
            Relationship::fixed('beau-parent', '%s du beau-parent')->married()->spouse()->parent(),
            Relationship::fixed('bru', '%s de la bru')->child()->wife(),
            Relationship::fixed('gendre', '%s du gendre')->child()->husband(),
            Relationship::fixed('belle-s??ur', '%s de la belle-s??ur')->spouse()->sister(),
            Relationship::fixed('beau-fr??re', '%s du beau-fr??re')->spouse()->brother(),
            Relationship::fixed('beau-fr??re/belle-s??ur', '%s du beau-fr??re/belle-s??ur')->spouse()->sibling(),
            Relationship::fixed('belle-s??ur', '%s de la belle-s??ur')->sibling()->wife(),
            Relationship::fixed('beau-fr??re', '%s du beau-fr??re')->sibling()->husband(),
            Relationship::fixed('beau-fr??re/belle-s??ur', '%s du beau-fr??re/belle-s??ur')->sibling()->spouse(),
            // Grandparents and above
            //"Trisa??eux" are an exception to the dynamic rule
            Relationship::fixed('trisa??eule maternelle', '%s de la trisa??eule maternelle')->mother()->parent()->parent()->mother(),
            Relationship::fixed('trisa??eul maternel', '%s du trisa??eul maternel')->mother()->parent()->parent()->father(),
            Relationship::fixed('trisa??eule paternelle', '%s de la trisa??eule paternelle')->father()->parent()->parent()->mother(),
            Relationship::fixed('trisa??eul paternel', '%s du trisa??eul paternel')->father()->parent()->parent()->father(),
            Relationship::fixed('trisa??eule', '%s de la trisa??eule')->parent()->parent()->parent()->mother(),
            Relationship::fixed('trisa??eul', '%s du trisa??eul')->parent()->parent()->parent()->father(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'grand-m??re maternelle', 'de la '))->mother()->ancestor()->female(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'grand-p??re maternel', 'du '))->mother()->ancestor()->male(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'grand-parent maternel', 'du '))->mother()->ancestor(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'grand-m??re paternelle', 'de la '))->father()->ancestor()->female(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'grand-p??re paternel', 'du '))->father()->ancestor()->male(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'grand-parent paternel', 'du '))->father()->ancestor(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'grand-m??re', 'de la '))->parent()->ancestor()->female(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'grand-p??re', 'du '))->parent()->ancestor()->male(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'grand-parent', 'du '))->parent()->ancestor(),
            // Grandchildren and below
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'petite-fille', 'de la '))->child()->descendant()->female(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'petit-fils', 'du '))->child()->descendant()->male(),
            Relationship::dynamic(static fn (int $n) => $firstCompound($n, 'petit-enfant', 'du '))->child()->descendant(),
            // Collateral relatives
            Relationship::dynamic(static fn (int $n) => $compound($n, 'grand-', 'tante', 'de la ', 'de la '))->ancestor()->sister(),
            Relationship::dynamic(static fn (int $n) => $compound($n, 'grand-', 'tante par alliance', 'de la ', 'de la '))->ancestor()->sibling()->wife(),
            Relationship::dynamic(static fn (int $n) => $compound($n, 'grand-', 'oncle', 'de l???', 'du '))->ancestor()->brother(),
            Relationship::dynamic(static fn (int $n) => $compound($n, 'grand-', 'oncle par alliance', 'de l???', 'du '))->ancestor()->sibling()->husband(),
            Relationship::dynamic(static fn (int $n) => $compound($n, 'petite-', 'ni??ce', 'de la ', 'de la '))->sibling()->descendant()->female(),
            Relationship::dynamic(static fn (int $n) => $compound($n, 'petite-', 'ni??ce par alliance', 'de la ', 'de la '))->married()->spouse()->sibling()->descendant()->female(),
            Relationship::dynamic(static fn (int $n) => $compound($n, 'petit-', 'neveu', 'du ', 'du '))->sibling()->descendant()->male(),
            Relationship::dynamic(static fn (int $n) => $compound($n, 'petit-', 'neveu par alliance', 'du ', 'du '))->married()->spouse()->sibling()->descendant()->male(),
            // Cousins (based on canon law)
            Relationship::dynamic(static fn (int $up, int $down) => $cousin($up, $down, 'F'))->cousin()->female(),
            Relationship::dynamic(static fn (int $up, int $down) => $cousin($up, $down, 'M'))->cousin()->male(),

        ];
    }
}
