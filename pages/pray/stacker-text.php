<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

// https://www.missionfrontiers.org/issue/article/the-ten-universal-elements

class PG_Stacker_Text {
    /*********************************************************************
     *
     * V2 TEXT STACK ELEMENTS
     *
     *********************************************************************/

    public static function _for_extraordinary_prayer( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Prayer Movement', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, we cry out for a prayer movement in %1$s of %2$s. Please, stir the %3$s believers here to pray for awakening.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'], $stack['location']['believers'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, cause a passion for prayer among the people of %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'John 17:20b-21', 'prayer-global-porch' ),
                'verse' => _x( 'I [Jesus] pray also for those who will believe in me through their message, that all of them may be one, Father, just as you are in me and I am in you. May they also be in us so that the world may believe that you have sent me.', 'John 17:20b-21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, stir the hearts of your people in %1$s of %2$s to agree with you in prayer.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'John 17:20b-21', 'prayer-global-porch' ),
                'verse' => _x( 'I [Jesus] pray also for those who will believe in me through their message, that all of them may be one, Father, just as you are in me and I am in you. May they also be in us so that the world may believe that you have sent me.', 'John 17:20b-21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, teach the church in %1$s of %2$s to increase their prayer for your kingdom to come.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Daniel 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'Now when Daniel learned that the decree had been published, he went home to his upstairs room where the windows opened toward Jerusalem. Three times a day he got down on his knees and prayed, giving thanks to his God...', 'Daniel 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, teach the children in %1$s of %2$s to pray with passion and pleading for your presence.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, awaken a burning desire for your presence and intimacy among the %1$s people living in %2$s of %3$s.', 'prayer-global-porch' ), $stack['location']['population'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord we pray you unite the %1$s believers to pray at all times in the Spirit, with all prayer and supplication, for spiritual breakthrough in %2$s.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => __( 'Philippians 4:6', 'prayer-global-porch' ),
                'verse' => _x( 'in every situation, by prayer and petition, with thanksgiving, present your requests to God.', 'Philippians 4:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'God, we pray for the believers in %1$s that they will know how to spend an hour in prayer with you.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Please, teach the %1$s believers in %2$s how to pray to you and how to listen for your voice. That they might follow you into the good works you have prepared for them.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'] ),
                'reference' => __( 'John 10:27', 'prayer-global-porch' ),
                'verse' => _x( 'My sheep listen to my voice; I know them, and they follow me.', 'John 10:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, answer the requests of your people in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( '1 John 5:14', 'prayer-global-porch' ),
                'verse' => _x( 'This is the boldness which we have toward him, that, if we ask anything according to his will, he listens to us.', '1 John 5:14', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_intentional_movement_strategy( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Intentional Multiplicative Strategies', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, you taught Paul to train Timothy to train faithful men who would train others. Please, teach the church of %1$s to do the same.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( '2 Timothy 2:2', 'prayer-global-porch' ),
                'verse' => _x( 'And the things you have heard me say in the presence of many witnesses entrust to reliable people who will also be qualified to teach others.', '2 Timothy 2:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, please equip every disciple to make disciples who make disciples in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( '2 Timothy 2:2', 'prayer-global-porch' ),
                'verse' => _x( 'And the things you have heard me say in the presence of many witnesses entrust to reliable people who will also be qualified to teach others.', '2 Timothy 2:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please, raise up a generation of disciples in %1$s of %2$s who will make disciples who make disciples.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, help the church in %1$s of %2$s to exponentially multiply disciples.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please make every disciple be a disciple maker, every home a training center, and every church a church planting movement in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, help the church in %1$s of %2$s do things that will multiply their numbers, not just add to them.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( '2 Corinthians 2:14', 'prayer-global-porch' ),
                'verse' => _x( 'But thanks be to God, who always leads us triumphantly as captives in Christ and through us spreads everywhere the fragrance of the knowledge of Him.', '2 Corinthians 2:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, help the church in %1$s of %2$s to not rely on buildings or programs, but on your Spirit and the simple faithfulness of every believer.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, reveal best practices for sharing the gospel in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, stir up passionate prayer among your people here. Thank you that you hear their prayers. Let them know that you hear, and in response to knowing let them cry out to you day and night for the lost.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 18:1', 'prayer-global-porch' ),
                'verse' => _x( 'And he told them a parable to the effect that they ought always to pray and not lose heart.', 'Luke 18:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you said if we sow abundantly, we will reap abundantly. Multiply the gospel witness here until everyone has heard your good news. Use your church to scatter seeds of truth everywhere, trusting you for the harvest.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 9:6', 'prayer-global-porch' ),
                'verse' => _x( 'The point is this: whoever sows sparingly will also reap sparingly, and whoever sows bountifully will also reap bountifully.', '2 Corinthians 9:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, raise up those who will plant churches among these people. Just as Paul appointed elders in every church, give your servants clear vision for establishing leadership and communities committed to you.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 14:23', 'prayer-global-porch' ),
                'verse' => _x( 'And when they had appointed elders for them in every church, with prayer and fasting they committed them to the Lord in whom they had believed.', 'Acts 14:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Your word is truth, Jesus. Let it take deep root here, becoming the final authority for how these believers live and lead. May they treasure your commands more than gold and take joy in the lives that come from obeying your word.', 'prayer-global-porch' ),
                'reference' => __( 'John 17:17', 'prayer-global-porch' ),
                'verse' => _x( 'Sanctify them in the truth; your word is truth.', 'John 17:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, raise up leaders from among these people who know their culture and speak their heart language. Help outside workers step back when possible so local voices can lead the way. Let the gospel take on the beautiful expressions of this community.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 14:23', 'prayer-global-porch' ),
                'verse' => _x( 'And when they had appointed elders for them in every church, with prayer and fasting they committed them to the Lord in whom they had believed.', 'Acts 14:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, you give gifts to every believer for building up the body. Empower ordinary people here to lead churches while keeping their regular jobs. Don\'t let them think ministry belongs only to the specially trained or educated.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 12:7', 'prayer-global-porch' ),
                'verse' => _x( 'To each is given the manifestation of the Spirit for the common good.', '1 Corinthians 12:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you promised to be present when even two or three gather in your name. Multiply small, simple churches that can meet anywhere and reproduce easily. Let the gospel spread from house to house throughout this community.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 18:20', 'prayer-global-porch' ),
                'verse' => _x( 'For where two or three are gathered in my name, there am I among them.', 'Matthew 18:20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, make these new churches so healthy they naturally reproduce themselves. Give them such joy in the gospel that they can\'t help but start new communities of faith. Let multiplication become as natural as breathing to them.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 4:20', 'prayer-global-porch' ),
                'verse' => _x( 'For we cannot but speak of what we have seen and heard.', 'Acts 4:20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, create holy urgency here for reaching the lost. Don\'t let your people settle into comfort when so many still need you. Speed up the process of making disciples who make disciples.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 16:15', 'prayer-global-porch' ),
                'verse' => _x( 'And he said to them, \'Go into all the world and proclaim the gospel to the whole creation.\'', 'Mark 16:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, grow churches here that worship you with joy, reach out with boldness, teach with faithfulness, serve with love, and fellowship as one. Make them complete expressions of your body, lacking nothing needed for spiritual health.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:15-16', 'prayer-global-porch' ),
                'verse' => _x( 'Rather, speaking the truth in love, we are to grow up in every way into him who is the head, into Christ.', 'Ephesians 4:15-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, let these people worship you in the language of their hearts, not foreign words that feel strange on their tongues. May their songs, prayers, and praises flow naturally from who you made them to be.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 67:3', 'prayer-global-porch' ),
                'verse' => _x( 'Let the peoples praise you, O God; let all the peoples praise you!', 'Psalm 67:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, you work through families and communities, not just individuals. When people here come to faith, let the gospel flow along the natural lines of relationship - from parent to child, friend to friend, neighbor to neighbor.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'And they said, \'Believe in the Lord Jesus, and you will be saved, you and your household.\'', 'Acts 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, don\'t let new believers sit on the sidelines waiting to be trained. Put them to work immediately sharing what little they know, teaching others to obey what they\'re learning, bearing fruit from the moment they\'re planted.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 28:19', 'prayer-global-porch' ),
                'verse' => _x( 'Go therefore and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit.', 'Matthew 28:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, fill your people here with holy boldness that overcomes every fear. Give them such confidence in your gospel that they speak freely even when it costs them. Let their passion for you burn brighter than their fear of people.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 4:31', 'prayer-global-porch' ),
                'verse' => _x( 'And when they had prayed, the place in which they were gathered together was shaken, and they were all filled with the Holy Spirit and continued to speak the word of God with boldness.', 'Acts 4:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you told us to count the cost of following you. When persecution comes to these believers, use it to refine their faith like gold in fire. Let suffering draw them closer to you and make their witness even more powerful.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 1:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'In this you rejoice, though now for a little while, if necessary, you have been grieved by various trials, so that the tested genuineness of your faith... may be found to result in praise and glory and honor.', '1 Peter 1:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, in times when human leaders fail and old ways crumble, show these people that you are the rock that never moves. Use uncertainty to create hunger for your eternal kingdom that will never be shaken.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 12:28', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore let us be grateful for receiving a kingdom that cannot be shaken, and thus let us offer to God acceptable worship, with reverence and awe.', 'Hebrews 12:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, help outside workers decrease so you can increase through local believers. Let foreign influence fade while indigenous faith shines brightly.', 'prayer-global-porch' ),
                'reference' => __( 'John 3:30', 'prayer-global-porch' ),
                'verse' => _x( 'He must increase, but I must decrease.', 'John 3:30', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we know that it is necessary that your servants suffer, even as you suffered. When your servants here face hardship, illness, or opposition, don\'t let it be in vain. Let their suffering lead to a fruitful harvest', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 1:24', 'prayer-global-porch' ),
                'verse' => _x( 'Now I rejoice in my sufferings for your sake, and in my flesh I am filling up what is lacking in Christ\'s afflictions for the sake of his body, that is, the church.', 'Colossians 1:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, teach these believers to pray without ceasing, bringing every need and praise before your throne. Let their prayers usher in what you want to accomplish here.', 'prayer-global-porch' ),
                'reference' => __( '1 Thessalonians 5:17', 'prayer-global-porch' ),
                'verse' => _x( 'Pray without ceasing.', '1 Thessalonians 5:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, multiply the opportunities for people here to hear your good news. Whether through conversations, media, or miraculous signs, let your truth reach every ear until no one can say they never heard.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 10:14', 'prayer-global-porch' ),
                'verse' => _x( 'How then will they call on him in whom they have not believed? And how are they to believe in him of whom they have never heard? And how are they to hear without someone preaching?', 'Romans 10:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Just as you told Paul through a vision to stay and speak boldly because you had many people in that city, show the people in this region where to plant churches.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 18:9-10', 'prayer-global-porch' ),
                'verse' => _x( 'And the Lord said to Paul one night in a vision, \'Do not be afraid, but go on speaking and do not be silent, for I am with you, and no one will attack you to harm you, for I have many in this city who are my people.\'', 'Acts 18:9-10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Your testimonies are our delight, they are our counselors. Lord, let the people here find the same joy in your word that we do. May they always look to it for advice, wisdom, and counsel. Don\'t let them stray from following it.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 119:24', 'prayer-global-porch' ),
                'verse' => _x( 'Your testimonies are my delight; they are my counselors.', 'Psalm 119:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, you chose fishermen and tax collectors to lead your first church. Raise up leaders here from ordinary backgrounds who love you deeply.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 1:26', 'prayer-global-porch' ),
                'verse' => _x( 'For consider your calling, brothers: not many of you were wise according to worldly standards, not many were powerful, not many were of noble birth.', '1 Corinthians 1:26', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, your earliest disciples met in homes, breaking bread and receiving it with glad and generous hearts. Multiply simple gatherings here that require nothing but hearts hungry for you.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 2:46', 'prayer-global-porch' ),
                'verse' => _x( 'And day by day, attending the temple together and breaking bread in their homes, they received their food with glad and generous hearts.', 'Acts 2:46', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, just as you sent out the seventy-two to proclaim your kingdom, let these churches send out their own members to start new communities of faith wherever they go.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 10:1,9', 'prayer-global-porch' ),
                'verse' => _x( 'After this the Lord appointed seventy-two others and sent them on ahead of him, two by two.', 'Luke 10:1,9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, the fields are already ripe for harvest now. Don\'t let your people wait. Create holy impatience here for reaching every person with your love. Don\'t let your people rest while their neighbors still walk in darkness.', 'prayer-global-porch' ),
                'reference' => __( 'John 4:35', 'prayer-global-porch' ),
                'verse' => _x( 'Do you not say, \'There are yet four months, then comes the harvest\'? Look, I tell you, lift up your eyes, and see that the fields are white for harvest.', 'John 4:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you are building your church, and even death cannot stop it. Make the churches here strong in every way - loving you supremely, loving each other deeply, and reaching out constantly to those who don\'t know you yet.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 16:18', 'prayer-global-porch' ),
                'verse' => _x( 'And I tell you, you are Peter, and on this rock I will build my church, and the gates of hell shall not prevail against it.', 'Matthew 16:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, people from every nation and language will worship you. Let praise rise from these people in words that come naturally from their deepest places. Don\'t make them adopt foreign ways of worship, but let them express their love for you in their own beautiful voices.', 'prayer-global-porch' ),
                'reference' => __( 'Revelation 7:9-10', 'prayer-global-porch' ),
                'verse' => _x( 'After this I looked, and behold, a great multitude that no one could number, from every nation, from all tribes and peoples and languages.', 'Revelation 7:9-10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, just as you saved Cornelius and all his household together, when people here come to faith, let salvation flow through family lines and friendship networks, bringing whole communities into your kingdom.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 10:27,44,48', 'prayer-global-porch' ),
                'verse' => _x( 'And he told us how he had seen the angel... While Peter was still saying these things, the Holy Spirit fell on all who heard the word.', 'Acts 10:27,44,48', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, perfect love casts out fear. Fill these believers with such overwhelming love for you and for the lost that no threat can silence their witness. Let their courage inspire others to speak boldly too.', 'prayer-global-porch' ),
                'reference' => __( '1 John 4:18', 'prayer-global-porch' ),
                'verse' => _x( 'There is no fear in love, but perfect love casts out fear.', '1 John 4:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you promised that following you would bring both joy and suffering. When believers here face opposition for your sake, let them rejoice that they\'re counted worthy to share in your sufferings.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 5:41', 'prayer-global-porch' ),
                'verse' => _x( 'Then they left the presence of the council, rejoicing that they were counted worthy to suffer dishonor for the name.', 'Acts 5:41', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, when human kingdoms shake and fall, your kingdom stands forever. Use times of uncertainty here to turn hearts toward you, the only leader who never fails and the only hope that never disappoints.', 'prayer-global-porch' ),
                'reference' => __( 'Daniel 2:44', 'prayer-global-porch' ),
                'verse' => _x( 'But in his days the kingdom of heaven shall break in pieces and consume all these kingdoms, and it shall stand forever.', 'Daniel 2:44', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you taught the disciples by walking with them daily and giving them chances to practice as they were learning. Train leaders here through real ministry experience, learning to shepherd by actually caring for your sheep.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 9:1-2', 'prayer-global-porch' ),
                'verse' => _x( 'And he called the twelve together and gave them power and authority over all demons and to cure diseases.', 'Luke 9:1-2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, you\'ve given every believer direct access to your throne through Jesus. You, and no other, have set these people apart for good works. Give local leaders freedom to act quickly when you call them forward. Don\'t let human bureaucracy slow down your work here.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 2:18', 'prayer-global-porch' ),
                'verse' => _x( 'For through him we both have access in one Spirit to the Father.', 'Ephesians 2:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you told us that persecution would come. When your servants here face trials, use their pain to deepen their dependence on you and to demonstrate your sustaining grace to watching neighbors.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 1:9', 'prayer-global-porch' ),
                'verse' => _x( 'Indeed, we felt that we had received the sentence of death. But that was to make us rely not on ourselves but on God who raises the dead.', '2 Corinthians 1:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, you promise that if we ask anything according to your will, you hear us. Stir hearts here to pray boldly for the salvation of their neighbors, knowing with confidence that you delight to answer prayers for the lost.', 'prayer-global-porch' ),
                'reference' => __( '1 John 5:14-15', 'prayer-global-porch' ),
                'verse' => _x( 'And this is the confidence that we have toward him, that if we ask anything according to his will he hears us.', '1 John 5:14-15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you taught us to pray for workers to be sent into the harvest fields. Raise up an army of prayer warriors here who will cry out day and night for laborers to reach every unreached soul in this place.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 10:2', 'prayer-global-porch' ),
                'verse' => _x( 'The harvest is plentiful, but the laborers are few. Therefore pray earnestly to the Lord of the harvest to send out laborers.', 'Luke 10:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, you help us in our weakness when we don\'t know how to pray. Intercede with groans too deep for words, especially for those who don\'t yet know you.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 8:26', 'prayer-global-porch' ),
                'verse' => _x( 'Likewise the Spirit helps us in our weakness. For we do not know what to pray for as we ought.', 'Romans 8:26', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you promise that where two or three gather in your name and agree about anything they ask, you will do it. Unite hearts here in desperate prayer for spiritual breakthrough in this place.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 18:19-20', 'prayer-global-porch' ),
                'verse' => _x( 'Again I say to you, if two of you agree on earth about anything they ask, it will be done for them by my Father in heaven.', 'Matthew 18:19-20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, Hannah poured out her soul before you in desperate prayer, and you heard her cry. Let believers here pray with that same intensity for the spiritual birth of new disciples in their families and neighborhoods.', 'prayer-global-porch' ),
                'reference' => __( '1 Samuel 1:15', 'prayer-global-porch' ),
                'verse' => _x( 'And she was in bitterness of soul and prayed to the Lord and wept bitterly.', '1 Samuel 1:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you said the one who sows bountifully will also reap bountifully. Give your people here hearts that are happy to scatter the good news everywhere they go, trusting you to bring forth an abundant harvest.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 9:6', 'prayer-global-porch' ),
                'verse' => _x( 'The point is this: whoever sows sparingly will also reap sparingly, and whoever sows bountifully will also reap bountifully.', '2 Corinthians 9:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, your word does not return empty but accomplishes what you desire. Saturate this place with gospel proclamation until your truth reaches every ear and heart. Don\'t let your words return to you empty. Let them yield fruit.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 55:11', 'prayer-global-porch' ),
                'verse' => _x( 'So shall my word be that goes out from my mouth; it shall not return to me empty.', 'Isaiah 55:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you promised that when the gospel is preached to all nations, then the end will come. Use your church here to urgently share you with everyone, hastening the day of your return.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 24:14', 'prayer-global-porch' ),
                'verse' => _x( 'And this gospel of the kingdom will be proclaimed throughout the whole world as a testimony to all nations, and then the end will come.', 'Matthew 24:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you said we would be your witnesses to the ends of the earth after receiving power from the Holy Spirit. Fill believers here with that same power and send them as witnesses throughout this region.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit has come upon you, and you will be my witnesses.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you command us to go into all the world and preach the gospel. Let that great commission burn in the hearts of your people here until no one is unreached.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 16:15', 'prayer-global-porch' ),
                'verse' => _x( 'And he said to them, \'Go into all the world and proclaim the gospel to the whole creation.\'', 'Mark 16:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, you desire all people to be saved and come to knowledge of the truth. Use your church here as instruments of salvation, carrying your truth to those still walking in darkness.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 2:3-4', 'prayer-global-porch' ),
                'verse' => _x( 'This is good, and it is pleasing in the sight of God our Savior, who desires all people to be saved and to come to the knowledge of the truth.', '1 Timothy 2:3-4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you said the fields are white for harvest, but the workers are few. Mobilize every believer here to become a harvester, gathering souls into your eternal kingdom with joy.', 'prayer-global-porch' ),
                'reference' => __( 'John 4:35-36', 'prayer-global-porch' ),
                'verse' => _x( 'Do you not say, \'There are yet four months, then comes the harvest\'? Look, I tell you, lift up your eyes, and see that the fields are white for harvest.', 'John 4:35-36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, your word is a lamp to our feet and light to our path. Let it illuminate every decision and direction for believers here, becoming their trusted guide in all of life.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 119:105', 'prayer-global-porch' ),
                'verse' => _x( 'Your word is a lamp to my feet and a light to my path.', 'Psalm 119:105', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, help every church and believer here build their lives on what you\'ve said. Don\'t let them be moved by changing opinions or popular ideas. Keep them anchored to your truth that never changes.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 24:35', 'prayer-global-porch' ),
                'verse' => _x( 'Heaven and earth will pass away, but my words will not pass away.', 'Matthew 24:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, let your word work powerfully in hearts here. Cut through confusion and lies. Show people the truth and help them change their lives because of what they read in Scripture every day.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'For the word of God is living and active, sharper than any two-edged sword.', 'Hebrews 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Make believers here hungry to learn from your word, Holy Spirit. Help them study it regularly and apply what they learn to their daily lives. Don\'t let them be satisfied with shallow understanding of your truth.', 'prayer-global-porch' ),
                'reference' => __( '2 Timothy 3:16-17', 'prayer-global-porch' ),
                'verse' => _x( 'All Scripture is breathed out by God and profitable for teaching, for reproof, for correction, and for training in righteousness.', '2 Timothy 3:16-17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, use your word to guide people here through every problem they face. When they don\'t know what to do, help them find clear answers in what you\'ve already written for them.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 19:7', 'prayer-global-porch' ),
                'verse' => _x( 'The law of the Lord is perfect, reviving the soul; the testimony of the Lord is sure, making wise the simple.', 'Psalm 19:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Help believers here actually obey what they read in Scripture, Jesus. Let their lives show they really believe what you\'ve taught them about following you.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 7:24', 'prayer-global-porch' ),
                'verse' => _x( 'Everyone then who hears these words of mine and does them will be like a wise man who built his house on the rock.', 'Matthew 7:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Reveal who has leadership gifts here and help them use those gifts well, Father. Don\'t let good potential leaders go unnoticed or undeveloped in these communities that need them.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'And he gave the apostles, the prophets, the evangelists, the shepherds and teachers, to equip the saints for the work of ministry.', 'Ephesians 4:11-12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Start a pattern here with local believers, Lord. Let them teach new Christians who can then teach even more people about following you. Create a multiplication of faithful teachers and leaders.', 'prayer-global-porch' ),
                'reference' => __( '2 Timothy 2:2', 'prayer-global-porch' ),
                'verse' => _x( 'And what you have heard from me in the presence of many witnesses entrust to faithful men, who will be able to teach others also.', '2 Timothy 2:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Raise up servant leaders here who genuinely care about people, Jesus, not ones who just want to be in charge or get recognition for themselves. Help them lead by example and love.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 10:43-44', 'prayer-global-porch' ),
                'verse' => _x( 'And whoever would be first among you must be slave of all.', 'Mark 10:43-44', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Use simple, faithful people here to lead your church, Father. Show your power through people who just love you and others with sincere hearts.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 1:26-27', 'prayer-global-porch' ),
                'verse' => _x( 'But God chose what is foolish in the world to shame the wise; God chose what is weak in the world to shame the strong.', '1 Corinthians 1:26-27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Don\'t let people here think ministry only belongs to pastors or people with special training, Father. Use every willing heart that wants to serve you and help others grow in their faith.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 12:7', 'prayer-global-porch' ),
                'verse' => _x( 'To each is given the manifestation of the Spirit for the common good.', '1 Corinthians 12:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Let people here see how simple it is to start new churches, Jesus. Remove any barriers that make church planting seem complicated or impossible for believers.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 18:20', 'prayer-global-porch' ),
                'verse' => _x( 'For where two or three are gathered in my name, there am I among them.', 'Matthew 18:20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Help believers here find joy even in suffering, Jesus, knowing it\'s a sign they\'re following you faithfully.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are you when others revile you and persecute you and utter all kinds of evil against you falsely on my account.', 'Matthew 5:11-12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'When persecution comes to your people here, use it to make their faith stronger and their witness more powerful, Father. Turn every attack into an opportunity for the gospel to spread further.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 8:28', 'prayer-global-porch' ),
                'verse' => _x( 'And we know that for those who love God all things work together for good, for those who are called according to his purpose.', 'Romans 8:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Prepare believers here for hardship, Lord, knowing that through many tribulations we must enter your kingdom.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 14:22', 'prayer-global-porch' ),
                'verse' => _x( 'And saying, \'It is through many tribulations that we must enter the kingdom of God.\'', 'Acts 14:22', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Replace every trace of fear in hearts here with love for you and for lost people around them, Jesus. Make their love stronger than any threat they might face for speaking about you.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 10:28', 'prayer-global-porch' ),
                'verse' => _x( 'And do not fear those who kill the body but cannot kill the soul. Rather fear him who can destroy both soul and body in hell.', 'Matthew 10:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Let courage mark every believer in this place, Lord. Help others recognize your people have been with you just by watching how they live and speak.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 4:13', 'prayer-global-porch' ),
                'verse' => _x( 'Now when they saw the boldness of Peter and John, and perceived that they were uneducated, common men, they were astonished.', 'Acts 4:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Give people here such confidence in you that they speak freely about you everywhere they go.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 10:32', 'prayer-global-porch' ),
                'verse' => _x( 'So everyone who acknowledges me before men, I also will acknowledge before my Father who is in heaven.', 'Matthew 10:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Help believers here trust you completely for both courage and wisdom in every opportunity to witness, Holy Spirit. Let them know you\'ll give them exactly what they need when they need it.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 12:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'And when they bring you before the synagogues and the rulers and the authorities, do not be anxious about how you should defend yourself.', 'Luke 12:11-12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Let worship here flow in the natural speech and cultural expressions that touch hearts most deeply, Lord. Use local instruments, melodies, and forms of expression that connect with people\'s souls in this place.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 2:6-8', 'prayer-global-porch' ),
                'verse' => _x( 'And at this sound the multitude came together, and they were bewildered, because each one was hearing them speak in his own language.', 'Acts 2:6-8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Multiply simple home gatherings here where believers can share life together, Lord. Create spiritual families that meet regularly here.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 2:46-47', 'prayer-global-porch' ),
                'verse' => _x( 'And day by day, attending the temple together and breaking bread in their homes, they received their food with glad and generous hearts.', 'Acts 2:46-47', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Raise up families here willing to open their homes for worship, fellowship, and reaching neighbors, Father. Turn their houses into centers of spiritual life and community transformation that impact their neighborhoods.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 16:3-5', 'prayer-global-porch' ),
                'verse' => _x( 'Greet Prisca and Aquila, my fellow workers in Christ Jesus... Greet also the church in their house.', 'Romans 16:3-5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Let homes here become centers of powerful prayer and breakthrough, Holy Spirit. Help believers gather regularly to seek your face and pray for their communities and region with faith and persistence.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 12:12', 'prayer-global-porch' ),
                'verse' => _x( 'So Peter was kept in prison, but earnest prayer for him was made to God by the church.', 'Acts 12:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Establish peaceful homes here where the gospel can take deep root, Lord.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 10:5-7', 'prayer-global-porch' ),
                'verse' => _x( 'And whatever house you enter, first say, \'Peace be to this house!\'', 'Luke 10:5-7', 'prayer-global-porch' ),
            ],

//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_abundant_gospel_sowing( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Abundant Gospel Sowing', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, please give new believers a yearning to see you praised in %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Psalm 96:3', 'prayer-global-porch' ),
                'verse' => _x( 'Declare his glory among the nations, his marvelous deeds among all peoples.', 'Psalm 96:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, give the disciples of the %1$s of %2$s words, actions, signs and wonders to proclaim the coming of the Kingdom.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Matthew 10:7', 'prayer-global-porch' ),
                'verse' => _x( 'As you go, proclaim this message: "The kingdom of heaven has come near."', 'Matthew 10:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, make the %1$s believers in %2$s to be brave and clear with the gospel to their %3$s neighbors.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'], $stack['location']['all_lost'] ),
                'reference' => __( 'Acts 14:3', 'prayer-global-porch' ),
                'verse' => _x( 'So Paul and Barnabas spent considerable time there, speaking boldly for the Lord, who confirmed the message of his grace by enabling them to perform signs and wonders.', 'Acts 14:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, we pray the believers are good spiritual stewards of their everyday relationships in %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, all authority was given to you, and you commanded all disciples in %1$s to make more disciples, and you promised to be with them. May your power and their obedience make more disciples today.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 28:18-20', 'prayer-global-porch' ),
                'verse' => _x( 'All authority in heaven and on earth has been given to me. Therefore go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit, and teaching them to obey everything I have commanded you. And surely I am with you always, to the very end of the age.', 'Matthew 28:18-20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, help the %1$s believers in %2$s to be spiritually intentional with their relationships among their %3$s lost friends and neighbors.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'], $stack['location']['all_lost'] ),
                'reference' => '',
                'verse' => '',
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, may your Spirit move powerfully in this country, bringing many to salvation.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 2:47', 'prayer-global-porch' ),
                'verse' => _x( 'praising God and enjoying the favor of all the people. And the Lord added to their number daily those who were being saved.', 'Acts 2:47', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, raise up bold witnesses who will share the gospel in every corner of this country.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses in Jerusalem, and in all Judea and Samaria, and to the ends of the earth.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May the believers in this country boldly proclaim the gospel, even when facing opposition.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 1:16', 'prayer-global-porch' ),
                'verse' => _x( 'For I am not ashamed of the gospel, because it is the power of God that brings salvation to everyone who believes: first to the Jew, then to the Gentile.', 'Romans 1:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that your gospel would penetrate the hearts of the people in this region and transform lives.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 1:16', 'prayer-global-porch' ),
                'verse' => _x( 'For I am not ashamed of the gospel, because it is the power of God that brings salvation to everyone who believes: first to the Jew, then to the Gentile.', 'Romans 1:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may your truth be preached with clarity and power in this country.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 4:12a', 'prayer-global-porch' ),
                'verse' => _x( 'For the word of God is alive and active.', 'Hebrews 4:12a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, may the gospel spread in this country like a wildfire, touching every heart and transforming lives.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 4:12a', 'prayer-global-porch' ),
                'verse' => _x( 'For the word of God is alive and active.', 'Hebrews 4:12a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, may your Word be spread widely in this country and reach those who have never heard the name of Jesus.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 52:7a', 'prayer-global-porch' ),
                'verse' => _x( 'How beautiful on the mountains are the feet of those who bring good news.', 'Isaiah 52:7a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we lift up the churches in this region to be filled with your Spirit, uniting believers to reach the lost with the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 133:1', 'prayer-global-porch' ),
                'verse' => _x( 'How good and pleasant it is when God’s people live together in unity!', 'Psalm 133:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the church in this region, that they would be bold and unwavering in sharing the gospel, even in the face of persecution, standing firm in their faith and trusting in your strength.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 1:16', 'prayer-global-porch' ),
                'verse' => _x( 'For I am not ashamed of the gospel, because it is the power of God that brings salvation to everyone who believes: first to the Jew, then to the Gentile.', 'Romans 1:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for those who are searching for truth, that they would find Jesus, the Way, the Truth, and the Life.', 'prayer-global-porch' ),
                'reference' => __( 'John 14:6', 'prayer-global-porch' ),
                'verse' => _x( 'Jesus answered, ‘I am the way and the truth and the life. No one comes to the Father except through me.’', 'John 14:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that you would bless the churches in this region, giving them the courage to preach the gospel boldly.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 4:29', 'prayer-global-porch' ),
                'verse' => _x( 'Now, Lord, consider their threats and enable your servants to speak your word with great boldness.', 'Acts 4:29', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for the church in this country to be bold in speaking the truth, despite the risks.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 4:29', 'prayer-global-porch' ),
                'verse' => _x( 'Now, Lord, consider their threats and enable your servants to speak your word with great boldness.', 'Acts 4:29', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that you open doors for the gospel to spread rapidly throughout this region.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 6:19', 'prayer-global-porch' ),
                'verse' => _x( 'Pray also for me, that whenever I speak, words may be given me so that I will fearlessly make known the mystery of the gospel.', 'Ephesians 6:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may your Word be spread across this region, taking root in hearts and transforming lives for your glory.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 55:11', 'prayer-global-porch' ),
                'verse' => _x( 'So is my word that goes out from my mouth: It will not return to me empty, but will accomplish what I desire and achieve the purpose for which I sent it.', 'Isaiah 55:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, raise up workers for the harvest in this country, to share your love with those who have never heard.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 9:37-38', 'prayer-global-porch' ),
                'verse' => _x( 'Then he said to his disciples, The harvest is plentiful but the workers are few. Ask the Lord of the harvest, therefore, to send out workers into his harvest field.', 'Matthew 9:37-38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that you would send laborers into the harvest fields of this region, and that many would come to faith in Jesus Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 9:37-38', 'prayer-global-porch' ),
                'verse' => _x( 'Then he said to his disciples, The harvest is plentiful but the workers are few. Ask the Lord of the harvest, therefore, to send out workers into his harvest field.', 'Matthew 9:37-38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that your light would shine brightly in the darkest corners of this region, drawing many to salvation.', 'prayer-global-porch' ),
                'reference' => __( 'John 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'The light shines in the darkness, and the darkness has not overcome it.', 'John 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for your mercy on this region, that the people may turn to you in repentance and faith.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 103:8', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is compassionate and gracious, slow to anger, abounding in love.', 'Psalm 103:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for an outpouring of your mercy in this region, bringing many to repentance and salvation.', 'prayer-global-porch' ),
                'reference' => __( '2 Peter 3:9', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is not slow in keeping his promise, as some understand slowness. Instead he is patient with you, not wanting anyone to perish, but everyone to come to repentance.', '2 Peter 3:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for divine encounters in this country, where many will come to know Jesus.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 18:15', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord your God will raise up for you a prophet like me from among you, from your fellow Israelites. You must listen to him.', 'Deuteronomy 18:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that you provide opportunities for believers to share the gospel with those who have never heard.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 5:20', 'prayer-global-porch' ),
                'verse' => _x( 'Then I heard a voice telling me, ‘Go, stand and speak to the people in the temple courts about this new life.’', 'Acts 5:20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for a mighty outpouring of your love on this region, that the people would experience your grace in powerful ways.', 'prayer-global-porch' ),
                'reference' => __( '1 John 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'We love because he first loved us.', '1 John 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the workers in this region, that they would find meaningful work that glorifies you.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 10:31', 'prayer-global-porch' ),
                'verse' => _x( 'So whether you eat or drink or whatever you do, do it all for the glory of God.', '1 Corinthians 10:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask that You would open doors for the gospel to spread in this region, using believers as vessels of Your love.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 16:9', 'prayer-global-porch' ),
                'verse' => _x( 'Because a great door for effective work has opened to me, and there are many who oppose me.', '1 Corinthians 16:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would stir the hearts of the people in this region to seek Your face and walk in obedience to Your Word.', 'prayer-global-porch' ),
                'reference' => __( '2 Chronicles 7:14', 'prayer-global-porch' ),
                'verse' => _x( 'if my people, who are called by my name, will humble themselves and pray and seek my face and turn from their wicked ways, then I will hear from heaven, and I will forgive their sin and will heal their land.', '2 Chronicles 7:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for a great revival in this region, that many would come to faith in Christ.', 'prayer-global-porch' ),
                'reference' => __( '2 Chronicles 7:14', 'prayer-global-porch' ),
                'verse' => _x( 'if my people, who are called by my name, will humble themselves and pray and seek my face and turn from their wicked ways, then I will hear from heaven, and I will forgive their sin and will heal their land.', '2 Chronicles 7:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the lost in this region, that their hearts would be softened to the gospel, and they would come to faith in Christ.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 4:4', 'prayer-global-porch' ),
                'verse' => _x( 'The god of this age has blinded the minds of unbelievers, so that they cannot see the light of the gospel that displays the glory of Christ, who is the image of God.', '2 Corinthians 4:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would pour out Your Holy Spirit on the churches in this region, empowering them to reach out to others with compassion and grace.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses in Jerusalem, and in all Judea and Samaria, and to the ends of the earth.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that Your Holy Spirit would empower believers in this region to be bold witnesses for Christ in their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses in Jerusalem, and in all Judea and Samaria, and to the ends of the earth.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would open doors for the gospel in this region, allowing Your Word to spread freely.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'And pray for us, too, that God may open a door for our message, so that we may proclaim the mystery of Christ, for which I am in chains.', 'Colossians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray that the gospel would penetrate the hearts of the youth in this region, that they may follow You wholeheartedly.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for a spirit of unity among the believers in this region, that they may be one in Christ and reach many with the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the believers in this region be bold in sharing their faith, speaking the truth in love.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 6:19', 'prayer-global-porch' ),
                'verse' => _x( 'Pray also for me, that whenever I speak, words may be given me so that I will fearlessly make known the mystery of the gospel.', 'Ephesians 6:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, may the gospel break down walls and barriers, reaching the hearts of many in this country.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 2:14', 'prayer-global-porch' ),
                'verse' => _x( 'For he himself is our peace, who has made the two groups one and has destroyed the barrier, the dividing wall of hostility.', 'Ephesians 2:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would bless the local ministries in this region, that they would bear fruit and reach many with the message of the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'John 15:5', 'prayer-global-porch' ),
                'verse' => _x( 'I am the vine; you are the branches. If you remain in me and I in you, you will bear much fruit; apart from me you can do nothing.', 'John 15:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for unity among the churches in this region, that they may work together to glorify You and reach the lost.', 'prayer-global-porch' ),
                'reference' => __( 'John 17:21', 'prayer-global-porch' ),
                'verse' => _x( 'that all of them may be one, Father, just as you are in me and I am in you. May they also be in us so that the world may believe that you have sent me.', 'John 17:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those in this region who are lost, that they may encounter the saving grace of Jesus Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 19:10', 'prayer-global-porch' ),
                'verse' => _x( 'For the Son of Man came to seek and to save the lost.', 'Luke 19:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask for the gospel to take root in the hearts of the people in this region, transforming lives and communities.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 8:15', 'prayer-global-porch' ),
                'verse' => _x( 'But the seed on good soil stands for those with a noble and good heart, who hear the word, retain it, and by persevering produce a crop.', 'Luke 8:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the nations surrounding this region, that they would be reached with the message of Your salvation.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 28:19-20', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit, and teaching them to obey everything I have commanded you. And surely I am with you always, to the very end of the age.', 'Matthew 28:19-20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for revival in the churches of this region, that they would be passionate about spreading the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Revelation 3:15-16', 'prayer-global-porch' ),
                'verse' => _x( 'I know your deeds, that you are neither cold nor hot. I wish you were either one or the other! So, because you are lukewarm—neither hot nor cold—I am about to spit you out of my mouth.', 'Revelation 3:15-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the hearts of the people in this region, that they would be open to the gospel and willing to hear Your voice.', 'prayer-global-porch' ),
                'reference' => __( 'Revelation 3:20', 'prayer-global-porch' ),
                'verse' => _x( 'Here I am! I stand at the door and knock. If anyone hears my voice and opens the door, I will come in and eat with that person, and they with me.', 'Revelation 3:20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the Church in this region, that they would be bold and unashamed in sharing the good news of Jesus Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 1:16', 'prayer-global-porch' ),
                'verse' => _x( 'For I am not ashamed of the gospel, because it is the power of God that brings salvation to everyone who believes: first to the Jew, then to the Gentile.', 'Romans 1:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask for the spread of Your gospel to reach every corner of this region, breaking down barriers and transforming lives.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 10:14', 'prayer-global-porch' ),
                'verse' => _x( 'How, then, can they call on the one they have not believed in? And how can they believe in the one of whom they have not heard? And how can they hear without someone preaching to them?', 'Romans 10:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for Your mercy to be extended to those who have yet to hear the gospel in this region, that they would encounter Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 10:14-15', 'prayer-global-porch' ),
                'verse' => _x( 'How, then, can they call on the one they have not believed in? And how can they believe in the one of whom they have not heard? And how can they hear without someone preaching to them?', 'Romans 10:14-15', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_persons_of_peace( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Person of Peace', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, help the %1$s believers find a person of peace today among the %2$s lost neighbors around them. And help them start discovery bible studies in these unbelieving homes.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['all_lost'] ),
                'reference' => __( 'Acts 10:30b-33', 'prayer-global-porch' ),
                'verse' => _x( 'Suddenly a man in shining clothes stood before me and said, ‘Cornelius, God has heard your prayer and remembered your gifts to the poor. Send to Joppa for Simon who is called Peter. He is a guest in the home of Simon the tanner, who lives by the sea.’ So I sent for you immediately, and it was good of you to come. Now we are all here in the presence of God to listen to everything the Lord has commanded you to tell us.”', 'Acts 10:30b-33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, help your children in %1$s find someone like the Samaritan Woman today. Someone who will open an entire town to your message of salvation.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'John 4:29–30', 'prayer-global-porch' ),
                'verse' => _x( 'So the woman left her water jar and went away into town and said to the people, 29 “Come, see a man who told me all that I ever did. Can this be the Christ?” They went out of the town and were coming to him.', 'John 4:29–30', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, like with the Ethiopian Eunuch, set up a meeting today between a faithful believer in %1$s and a person seeking to understand the truth.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Acts 8:34-35', 'prayer-global-porch' ),
                'verse' => _x( 'The eunuch asked Philip, “Tell me, please, who is the prophet talking about, himself or someone else?” Then Philip began with that very passage of Scripture and told him the good news about Jesus.', 'Acts 8:34-35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, reveal yourself to a faithful non-believer today, someone like Cornelius, and then Father please connect him with the church in %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Acts 10:30-31', 'prayer-global-porch' ),
                'verse' => _x( 'Cornelius answered: “Three days ago I was in my house praying at this hour, at three in the afternoon. Suddenly a man in shining clothes stood before me and said, ‘Cornelius, God has heard your prayer and remembered your gifts to the poor."', 'Acts 10:30-31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, guide someone in the church in %1$s of %2$s to a person ready to receive the message of the gospel, like Lydia, and who will then open her home to faith.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Acts 16:14', 'prayer-global-porch' ),
                'verse' => _x( 'One of those listening was a woman from the city of Thyatira named Lydia, a dealer in purple cloth. She was a worshiper of God. The Lord opened her heart to respond to Paul’s message.', 'Acts 16:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, help the disciples in %1$s of %2$s to find a person of peace today, like the Philippian jailer, who heard and was immediately baptized with his whole family.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Acts 16:32–33', 'prayer-global-porch' ),
                'verse' => _x( 'And they spoke the word of the Lord to him and to all who were in his house. And he took them the same hour of the night and washed their wounds; and he was baptized at once, he and all his family.', 'Acts 16:32–33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, like with the centurion who came to you for his sick servant, please call into your house those who have great faith but are not yet yours in %1$s of %2$s', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Luke 7:9–10', 'prayer-global-porch' ),
                'verse' => _x( 'When Jesus heard these things, he marveled at him, and turning to the crowd that followed him, said, “I tell you, not even in Israel have I found such faith.” And when those who had been sent returned to the house, they found the servant well.', 'Luke 7:9–10', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_prioritizing_priesthood_of_believers( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Priesthood of Believers', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, guide the church in %1$s to see their community as a holy priesthood, offering spiritual sacrifices acceptable to God.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( '1 Peter 2:5', 'prayer-global-porch' ),
                'verse' => _x( 'you also, like living stones, are being built into a spiritual house to be a holy priesthood, offering spiritual sacrifices acceptable to God through Jesus Christ.', '1 Peter 2:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, thank you that in your kindness you have made every believer in %1$s a priest, who can offer spiritual sacrifices to you through Jesus.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 21:43-44', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore I tell you that the kingdom of God will be taken away from you and given to a people who will produce its fruit. He who falls on this stone will be broken to pieces, but he on whom it falls will be crushed.”', 'Matthew 21:43-44', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, please convict each believer in %1$s to take up their calling as a priesthood of believers and pray for the %2$s lost around them.', 'prayer-global-porch' ), $stack['location']['full_name'], $stack['location']['all_lost'] ),
                'reference' => __( '1 Peter 2:5', 'prayer-global-porch' ),
                'verse' => _x( 'you also, like living stones, are being built into a spiritual house to be a holy priesthood', '1 Peter 2:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please raise up every one you have called in %1$s to become worthy of their calling, and offer spiritual sacrifices acceptable to you through Jesus.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Ephesians 4:1', 'prayer-global-porch' ),
                'verse' => _x( 'I urge you to live a life worthy of the calling you have received', 'Ephesians 4:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, please convict the believers in %1$s to not assume the ministry is for professional clergy, but for all who have been called by you.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, encourage the %1$s believers to have boldness before you, since they have a great high priest who has passed through the heavens, Jesus the Son of God.', 'prayer-global-porch' ), $stack['location']['believers'] ),
                'reference' => __( 'Hebrews 4:14-16', 'prayer-global-porch' ),
                'verse' => _x( 'Since then we have a great high priest who has passed through the heavens, Jesus, the Son of God, let us hold fast our confession.', 'Hebrews 4:14-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, you are the great high priest, please make the %1$s believers in %2$s a worthy priesthood under you.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'] ),
                'reference' => __( 'Hebrews 4:14', 'prayer-global-porch' ),
                'verse' => _x( 'Since then we have a great high priest who has passed through the heavens, Jesus, the Son of God, let us hold fast our confession.', 'Hebrews 4:14', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, empower the church in this country to make disciples who will multiply and spread your Kingdom.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 28:19', 'prayer-global-porch' ),
                'verse' => _x( 'Go and make disciples of all nations.', 'Matthew 28:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, may the believers in this region remain faithful to you, even in the face of persecution and hardship.', 'prayer-global-porch' ),
                'reference' => __( 'John 16:33', 'prayer-global-porch' ),
                'verse' => _x( 'I have told you these things, so that in me you may have peace. In this world you will have trouble. But take heart! I have overcome the world.', 'John 16:33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for wisdom for the Church in this region, that it may know how to effectively minister in this season.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for believers in this country to speak with love and grace, reflecting your truth.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 4:6', 'prayer-global-porch' ),
                'verse' => _x( 'Let your conversation be always full of grace, seasoned with salt, so that you may know how to answer everyone.', 'Colossians 4:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the believers in this region live lives of integrity, reflecting the character of Christ in everything they do.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:16', 'prayer-global-porch' ),
                'verse' => _x( 'In the same way, let your light shine before others, that they may see your good deeds and glorify your Father in heaven.', 'Matthew 5:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the families in this region be grounded in your love, supporting one another in faith.', 'prayer-global-porch' ),
                'reference' => __( 'John 15:12', 'prayer-global-porch' ),
                'verse' => _x( 'Love one another as I have loved you.', 'John 15:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, may your joy fill the hearts of the believers in this region, that they may be a living testimony of your grace.', 'prayer-global-porch' ),
                'reference' => __( 'Nehemiah 8:10b', 'prayer-global-porch' ),
                'verse' => _x( 'The joy of the Lord is your strength.', 'Nehemiah 8:10b', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that you would help the believers in this region to live lives of integrity and truth.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 20:7', 'prayer-global-porch' ),
                'verse' => _x( 'The righteous lead blameless lives; blessed are their children after them.', 'Proverbs 20:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that the believers in this region would continue to grow in faith, becoming disciples who make disciples for your Kingdom.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 28:19', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit.', 'Matthew 28:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray your blessing over the churches in this region. Strengthen them with boldness and faith, that they may proclaim the gospel fearlessly and stand firm in your truth.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 1:16', 'prayer-global-porch' ),
                'verse' => _x( 'We are not ashamed of the gospel, because it is the power of God that brings salvation.', 'Romans 1:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, let every believer in this country be a beacon of hope and light in their community.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:14', 'prayer-global-porch' ),
                'verse' => _x( 'You are the light of the world. A town built on a hill cannot be hidden.', 'Matthew 5:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the believers in this region to be a light in the darkness, pointing the lost to the hope found in Jesus Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:14', 'prayer-global-porch' ),
                'verse' => _x( 'You are the light of the world. A town built on a hill cannot be hidden.', 'Matthew 5:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the believers in this country be salt and light, showing the world the love of Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:13-14', 'prayer-global-porch' ),
                'verse' => _x( 'You are the salt of the earth. But if the salt loses its saltiness, how can it be made salty again? It is no longer good for anything, except to be thrown out and trampled underfoot. You are the light of the world. A town built on a hill cannot be hidden.', 'Matthew 5:13-14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the youth in this region, that they would grow up to be strong in faith and influence their generation for Your kingdom.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for revival in this region, that hearts would be turned to You, and that Your kingdom would be established in every community.', 'prayer-global-porch' ),
                'reference' => __( '2 Chronicles 7:14', 'prayer-global-porch' ),
                'verse' => _x( 'if my people, who are called by my name, will humble themselves and pray and seek my face and turn from their wicked ways, then I will hear from heaven, and I will forgive their sin and will heal their land.', '2 Chronicles 7:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, may Your Spirit empower believers to live out the gospel in every sphere of life.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses in Jerusalem, and in all Judea and Samaria, and to the ends of the earth.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, may Your Holy Spirit empower believers in this region to boldly proclaim the Gospel to their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses in Jerusalem, and in all Judea and Samaria, and to the ends of the earth.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray that the believers in this region would be filled with Your Spirit, equipped to spread the message of salvation.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8a', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses.', 'Acts 1:8a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, may the church in this country grow stronger through the power of the Holy Spirit.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8a', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you.', 'Acts 1:8a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for families in this region, that they would be built on a foundation of love, unity, and faith in Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for families in this region to reflect Your love and grace, with fathers and mothers leading with wisdom and kindness.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 6:4', 'prayer-global-porch' ),
                'verse' => _x( 'Fathers, do not exasperate your children; instead, bring them up in the training and instruction of the Lord.', 'Ephesians 6:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are searching for purpose in this region, that they would find their purpose in You and live lives that honor You.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 29:11', 'prayer-global-porch' ),
                'verse' => _x( 'For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future.', 'Jeremiah 29:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray that Your Word would take root in the hearts of all believers in this region, causing them to bear much fruit.', 'prayer-global-porch' ),
                'reference' => __( 'John 15:7-8', 'prayer-global-porch' ),
                'verse' => _x( 'If you remain in me and my words remain in you, ask whatever you wish, and it will be done for you. This is to my Father’s glory, that you bear much fruit, showing yourselves to be my disciples.', 'John 15:7-8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the children in this region, that they would grow in wisdom, stature, and favor with You and with others.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 2:52', 'prayer-global-porch' ),
                'verse' => _x( 'And Jesus grew in wisdom and stature, and in favor with God and man.', 'Luke 2:52', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would raise up strong disciples in this region who are committed to making disciples of others.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 28:19-20', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit, and teaching them to obey everything I have commanded you. And surely I am with you always, to the very end of the age.', 'Matthew 28:19-20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, please help us to be salt and light in this region, shining Your love to those who are lost and experiencing darkness.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:13-14', 'prayer-global-porch' ),
                'verse' => _x( 'You are the salt of the earth. But if the salt loses its saltiness, how can it be made salty again? It is no longer good for anything, except to be thrown out and trampled underfoot. You are the light of the world. A town built on a hill cannot be hidden.', 'Matthew 5:13-14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, may the believers in this country shine as salt and light, reflecting the love of Christ in both word and action to a watching world.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:13-14', 'prayer-global-porch' ),
                'verse' => _x( 'You are the salt of the earth. But if the salt loses its saltiness, how can it be made salty again? It is no longer good for anything, except to be thrown out and trampled underfoot. You are the light of the world. A town built on a hill cannot be hidden.', 'Matthew 5:13-14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that Your Kingdom would advance in this region through the lives of everyday believers who boldly share Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:14-16', 'prayer-global-porch' ),
                'verse' => _x( 'You are the light of the world. A town built on a hill cannot be hidden. 15 Neither do people light a lamp and put it under a bowl. Instead they put it on its stand, and it gives light to everyone in the house. 16 In the same way, let your light shine before others, that they may see your good deeds and glorify your Father in heaven.', 'Matthew 5:14-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, let every believer in this country be a beacon of hope and light to others in their community.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:16', 'prayer-global-porch' ),
                'verse' => _x( 'In the same way, let your light shine before others, that they may see your good deeds and glorify your Father in heaven.', 'Matthew 5:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the young adults in this region who are making life decisions, that they would seek Your will and follow Your guidance.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the youth in this region, that they would make wise choices and follow You all the days of their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your guidance for those seeking to make a difference in this region, that their efforts would bear lasting fruit.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the young adults in this region, that they would walk in Your ways and be wise in their decisions.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the young people in this region, that they would grow in wisdom and understanding, seeking You with all their hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the students in this region, that they would excel in their studies and use their knowledge for the advancement of Your Kingdom.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the students in this region, that they would grow in knowledge and wisdom, and that their hearts would be open to You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that Your Spirit would move in the hearts of the youth in this region, igniting a passion for Your Word and Your mission.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 119:9', 'prayer-global-porch' ),
                'verse' => _x( 'How can a young person stay on the path of purity? By living according to your word.', 'Psalm 119:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the youth in this region, that they would be a generation that seeks after You with their whole hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 24:3-4', 'prayer-global-porch' ),
                'verse' => _x( 'Who may ascend the mountain of the Lord? Who may stand in his holy place? The one who has clean hands and a pure heart, who does not trust in an idol or swear by a false god.', 'Psalm 24:3-4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the youth in this region, that they would resist the pressures of the world and grow in their identity in Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 12:2', 'prayer-global-porch' ),
                'verse' => _x( 'Do not conform to the pattern of this world, but be transformed by the renewing of your mind. Then you will be able to test and approve what God’s will is—his good, pleasing and perfect will.', 'Romans 12:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the young people in this region, that they would resist the pressures of this world and choose to live for You.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 12:2', 'prayer-global-porch' ),
                'verse' => _x( 'Do not conform to the pattern of this world, but be transformed by the renewing of your mind. Then you will be able to test and approve what God’s will is—his good, pleasing and perfect will.', 'Romans 12:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those in the workplace in this region, that they would be honest, diligent, and a light to their colleagues.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_unleashing_simple_churches( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Unleashing Simple Churches', 'prayer-global-porch' );
        $the_church_section_label = __( 'The Church', 'prayer-global-porch' );
        $church_planting_section_label = __( 'Church Planting', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'God, guide the %1$s believers in %2$s to multiply spiritual families that love you, love each other, and make disciples.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, help the %1$s believers in %2$s to start simple multiplying churches in their homes.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, we pray that %1$s of %2$s be filled with simple churches in every neighborhood.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Isaiah 11:9', 'prayer-global-porch' ),
                'verse' => _x( 'For the earth will be full of the knowledge of the Lord, as the waters cover the sea.', 'Isaiah 11:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, we ask for %1$s new simple churches in %2$s of %3$s. Place a simple church in every community of the %4$s people living here.', 'prayer-global-porch' ), $stack['location']['new_churches_needed'], $stack['location']['admin_level_title'], $stack['location']['full_name'], $stack['location']['population'] ),
                'reference' => __( 'Psalm 72:19', 'prayer-global-porch' ),
                'verse' => _x( 'And blessed be His glorious name forever; And may the whole earth be filled with His glory. Amen, and Amen.', 'Psalm 72:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, teach the %1$s believers in %2$s of %3$s the wisdom of how to form simple, reproducible churches of 12-30 in every neighborhood.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, bless %1$s of %2$s with a multiplying movement of house churches.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Numbers 14:21', 'prayer-global-porch' ),
                'verse' => _x( '...but indeed, as I live, all the earth will be filled with the glory of the Lord.', 'Numbers 14:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'God, we pray both the men and women of %1$s will find ways to meet in groups of two or three to encourage and correct one another from your Word.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $the_church_section_label,
                'prayer' => sprintf( __( 'Father, multiply brothers, sisters, and mothers to our spiritual family in %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 12:48-50', 'prayer-global-porch' ),
                'verse' => _x( 'He replied to him, “Who is my mother, and who are my brothers?” Pointing to his disciples, he said, “Here are my mother and my brothers. For whoever does the will of my Father in heaven is my brother and sister and mother.”', 'Matthew 12:48-50', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $the_church_section_label,
                'prayer' => sprintf( __( 'Father, we rejoice that you who began a good work in the church of %1$s will carry it on to completion until the day of Jesus Christ!', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Philippians 1:6', 'prayer-global-porch' ),
                'verse' => _x( 'being confident of this, that he who began a good work in you will carry it on to completion until the day of Christ Jesus.', 'Philippians 1:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $the_church_section_label,
                'prayer' => sprintf( __( 'Father, remind your church in %1$s that you have set your Son over all rule and authority, power and dominion, and every name that is invoked.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Ephesians 1:20-21', 'prayer-global-porch' ),
                'verse' => _x( 'he raised Christ from the dead and seated him at his right hand in the heavenly realms, far above all rule and authority, power and dominion, and every name that is invoked, not only in the present age but also in the one to come.', 'Ephesians 1:20-21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $church_planting_section_label,
                'prayer' => sprintf( __( 'Father, help %1$s new simple churches start among the %2$s people in %3$s of %4$s. One within reach of everyone living here.', 'prayer-global-porch' ), $stack['location']['new_churches_needed'], $stack['location']['population'], $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'Habakkuk 2:14', 'prayer-global-porch' ),
                'verse' => _x( 'For the earth will be filled with the knowledge of the glory of the Lord as the waters cover the sea.', 'Habakkuk 2:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $church_planting_section_label,
                'prayer' => sprintf( __( 'Spirit, please start new house churches in every neighborhood of %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Habakkuk 2:14', 'prayer-global-porch' ),
                'verse' => _x( 'For the earth will be filled with the knowledge of the glory of the Lord as the waters cover the sea.', 'Habakkuk 2:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $church_planting_section_label,
                'prayer' => sprintf( __( 'Spirit, please give every church in %1$s of %2$s a passion to plant another simple church.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $church_planting_section_label,
                'prayer' => sprintf( __( 'Father, show your mercy on the %1$s people in %2$s who are far from you. Please add %3$s new house churches this year.', 'prayer-global-porch' ), $stack['location']['all_lost'], $stack['location']['name'], $stack['location']['new_churches_needed'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $church_planting_section_label,
                'prayer' => sprintf( __( 'Father, we agree with your desire that the people in %1$s of %2$s hear about you.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Romans 15:21', 'prayer-global-porch' ),
                'verse' => _x( '"Those who were not told about him will see, and those who have not heard will understand."', 'Romans 15:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $church_planting_section_label,
                'prayer' => sprintf( __( 'Father, let every disciple be a disciple maker, every home a training center, and every church a church planting movement in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $church_planting_section_label,
                'prayer' => sprintf( __( 'Father, we ask for networks of simple churches in every city in %1$s of %2$s, like Paul planted in Corinth and Ephesus.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( '1 Corinthians 16:19', 'prayer-global-porch' ),
                'verse' => _x( 'The churches in the province of Asia send you greetings. Aquila and Priscilla greet you warmly in the Lord, and so does the church that meets at their house.', '1 Corinthians 16:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $church_planting_section_label,
                'prayer' => sprintf( __( 'Jesus, %1$s people live in %2$s of %3$s. Please, give them %4$s new simple churches this year.', 'prayer-global-porch' ), $stack['location']['population'], $stack['location']['admin_level_title'], $stack['location']['name'], $stack['location']['new_churches_needed'] ),
                'reference' => '',
                'verse' => '',
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those in this region seeking to plant churches, that You would guide them, provide for them, and establish their work.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 3:6', 'prayer-global-porch' ),
                'verse' => _x( 'I planted the seed, Apollos watered it, but God has been making it grow.', '1 Corinthians 3:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the churches in this region, that they would grow in number and strength, reaching the lost with the message of salvation.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 2:47', 'prayer-global-porch' ),
                'verse' => _x( 'Praising God and enjoying the favor of all the people. And the Lord added to their number daily those who were being saved.', 'Acts 2:47', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_bible_access( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Bible Access', 'prayer-global-porch' );
        $current_templates = [];

        // focus for non christians is exposure to the Word of God and access to a bible
        $current_templates['non_christians'] = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please give the people in %1$s of %2$s access to a Bible in their own language.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, how will they hear without a preacher? How will they preach unless they have a Bible? Please give the people in %1$s of %2$s access to a Bible in their own language.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Romans 10:14-15', 'prayer-global-porch' ),
                'verse' => _x( 'How, then, can they call on the one they have not believed in? And how can they believe in the one of whom they have not heard? And how can they hear without someone preaching to them? And how can anyone preach unless they are sent? As it is written: “How beautiful are the feet of those who bring good news!”', 'Romans 10:14-15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please remove the barriers that keep the %1$s who are far from you in %2$s from having access to a Bible.', 'prayer-global-porch' ), $stack['location']['non_christians'], $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 24:14', 'prayer-global-porch' ),
                'verse' => _x( 'And this gospel of the kingdom will be preached in the whole world as a testimony to all nations, and then the end will come.', 'Matthew 24:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, put your Bible in the hands of the %1$s, who are far from you and live in this place.', 'prayer-global-porch' ), $stack['location']['non_christians'] ),
                'reference' => __( 'Psalm 119:9-10', 'prayer-global-porch' ),
                'verse' => _x( 'How can a young person stay on the path of purity? By living according to your Word. I seek you with all my heart; do not let me stray from your commands.', 'Psalm 119:9-10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, it’s possible most of the %1$s lost people in  %2$s have never held or opened a Bible. Please change this, Father.', 'prayer-global-porch' ), $stack['location']['non_christians'], $stack['location']['full_name'] ),
                'reference' => __( 'Romans 10:17', 'prayer-global-porch' ),
                'verse' => _x( 'Yet faith comes from listening to this Good News—the Good News about Christ.', 'Romans 10:17', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates['non_christians'] = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are lost in this region, that their eyes may be opened to the truth of the gospel, and they may be saved.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 4:4', 'prayer-global-porch' ),
                'verse' => _x( 'The god of this age has blinded the minds of unbelievers, so that they cannot see the light of the gospel that displays the glory of Christ, who is the image of God.', '2 Corinthians 4:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, please provide more Bibles in the local language, that everyone might have access to them and be able to read Your Word.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 119:105', 'prayer-global-porch' ),
                'verse' => _x( 'Your word is a lamp for my feet, a light on my path.', 'Psalm 119:105', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for a deep hunger for Your Word to arise in this region, that many would long to know You more.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 119:131', 'prayer-global-porch' ),
                'verse' => _x( 'I open my mouth and pant, longing for your commands.', 'Psalm 119:131', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, please open hearts to your Word, even in places where it is not yet available.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 119:130', 'prayer-global-porch' ),
                'verse' => _x( 'The unfolding of your words gives light; it gives understanding to the simple.', 'Psalm 119:130', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for your Word to take root in the hearts of many in this region, bringing transformation.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'The word of God is alive and active.', 'Hebrews 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, please provide more Bibles in the local language, that all might read Your Word.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 119:105', 'prayer-global-porch' ),
                'verse' => _x( 'Your word is a lamp for my feet, a light on my path.', 'Psalm 119:105', 'prayer-global-porch' ),
            ],
        ];

        // Focus on christian adherents is re engagement with the Bible directly, not through traditions or church leaders.
        $current_templates['christian_adherents'] = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, there are %1$s people in %2$s of %3$s who claim Christianity, but may have never read the Bible. Please challenge them today to read the Bible for themselves.', 'prayer-global-porch' ), $stack['location']['christian_adherents'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( '2 Timothy 3:16', 'prayer-global-porch' ),
                'verse' => _x( 'All Scripture is God-breathed and is useful for teaching, rebuking, correcting and training in righteousness', '2 Timothy 3:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, of the %1$s people in %2$s of %3$s who claim Christianity, challenge some of them to pick up your Word and read it for themselves today.', 'prayer-global-porch' ), $stack['location']['christian_adherents'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'John 8:32', 'prayer-global-porch' ),
                'verse' => _x( 'Then you will know the truth, and the truth will set you free.', 'John 8:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, your Word is essential for life and growth. Please challenge the %1$s cultural Christians in %2$s of %3$s to read your Word for themselves today.', 'prayer-global-porch' ), $stack['location']['christian_adherents'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Matthew 4:4', 'prayer-global-porch' ),
                'verse' => _x( "It is written: 'Man shall not live by bread alone, but by every word that comes from the mouth of God.'", 'Matthew 4:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, the %1$s of %2$s will disappear one day, but your Word will never disappear. Call all who claim Christianity to anchor their lives on your Word.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Matthew 24:35', 'prayer-global-porch' ),
                'verse' => _x( 'Heaven and earth will disappear, but my words will never disappear.', 'Matthew 24:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, your Word can be a lamp to the feet of the %1$s people in %2$s of %3$s who claim to know you, if they open it and read it today.', 'prayer-global-porch' ), $stack['location']['christian_adherents'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:105', 'prayer-global-porch' ),
                'verse' => _x( 'your Word is a lamp to my feet and a light to my path.', 'Psalm 119:105', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, make the %1$s people in %2$s of %3$s who claim to know you, brave enough to let the Bible weigh their thoughts and intentions today.', 'prayer-global-porch' ), $stack['location']['christian_adherents'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Hebrews 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'For the word of God is living and powerful, and sharper than any two-edged sword, piercing even to the division of soul and spirit, and of joints and marrow, and is a discerner of the thoughts and intents of the heart.', 'Hebrews 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, help get online Bibles and Bible apps onto the phones of the %1$s people who claim to know you, so they can read everyday.', 'prayer-global-porch' ), $stack['location']['christian_adherents'] ),
                'reference' => '',
                'verse' => '',
            ],
        ];
        $ai_templates['christian_adherents'] = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that your Word would take root in the hearts of the people of this region and bring about a great harvest.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 12:24', 'prayer-global-porch' ),
                'verse' => _x( 'But the word of God continued to spread and flourish.', 'Acts 12:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the spiritual health of this country, that your Word would penetrate hearts and transform lives.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 4:12a', 'prayer-global-porch' ),
                'verse' => _x( 'For the word of God is alive and active.', 'Hebrews 4:12a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that your gospel would reach the farthest corners of this region, bringing many to salvation.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 52:7a', 'prayer-global-porch' ),
                'verse' => _x( 'How beautiful on the mountains are the feet of those who bring good news.', 'Isaiah 52:7a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that you make your Word known to all who seek understanding.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 9:10', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of wisdom, and knowledge of the Holy One is understanding.', 'Proverbs 9:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that you make your Word known to those who long for understanding.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 9:10', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of wisdom, and knowledge of the Holy One is understanding.', 'Proverbs 9:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the truth of your Word spread like fire, igniting hearts in this region today.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 33:4', 'prayer-global-porch' ),
                'verse' => _x( 'For the word of the Lord is right and true; he is faithful in all he does.', 'Psalm 33:4', 'prayer-global-porch' ),
            ]
        ];

        // Focus for believers is engagement with the Bible, faithfulness to the Word.
        $current_templates['believers'] = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please provide access to your Word for everyone, especially believers in %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 24:14', 'prayer-global-porch' ),
                'verse' => _x( 'And this gospel of the kingdom will be preached in the whole world as a testimony to all nations, and then the end will come.', 'Matthew 24:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, if there is even one of the %1$s believers in %2$s who does not have a Bible, please provide them one today.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, let your Word be a lamp to the feet of the %1$s believers in %2$s.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'] ),
                'reference' => __( 'Psalm 119:105', 'prayer-global-porch' ),
                'verse' => _x( 'your Word is a lamp to my feet and a light to my path.', 'Psalm 119:105', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, help the %1$s believers in %2$s desire the Bible as newborn babies desire milk.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'] ),
                'reference' => __( '1 Peter 2:2', 'prayer-global-porch' ),
                'verse' => _x( 'Desire God’s pure word as newborn babies desire milk. Then you will grow in your salvation.', '1 Peter 2:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, provide a good translation of the Bible for the %1$s believers in %2$s.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, provide a Bible for every believer in %1$s, and teach them to obey it.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'James 1:23-25', 'prayer-global-porch' ),
                'verse' => _x( 'For if you listen to the word and don’t obey, it is like glancing at your face in a mirror. 24 you see yourself, walk away, and forget what you look like. 25 But if you look carefully into the perfect law that sets you free, and if you do what it says and don’t forget what you heard, then God will bless you for doing it.', 'James 1:23-25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, inspire Bible translators to communicate the Scriptures accurately in the heart languages spoken in %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
        ];
        $ai_templates['believers'] = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, may your Word take root deeply in the hearts of believers in this country and bear much fruit.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 8:15', 'prayer-global-porch' ),
                'verse' => _x( 'But the seed on good soil stands for those with a noble and good heart, who hear the word, retain it, and by persevering produce a crop.', 'Luke 8:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray that you would raise up faithful disciples who will spread your Word throughout this region.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 28:19', 'prayer-global-porch' ),
                'verse' => _x( 'Go and make disciples of all nations.', 'Matthew 28:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the believers in this region rise to become ambassadors of reconciliation, spreading the gospel of peace.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 5:19', 'prayer-global-porch' ),
                'verse' => _x( 'God was reconciling the world to himself in Christ, not counting people’s sins against them.', '2 Corinthians 5:19', 'prayer-global-porch' ),
            ],
        ];


        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $templates = $templates[$stack['location']['favor']];
        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_internet_gospel_access( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Media', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please help good, online teachers get the gospel on YouTube and into the %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Matthew 24:14', 'prayer-global-porch' ),
                'verse' => _x( 'And this gospel of the kingdom will be preached in the whole world as a testimony to all nations, and then the end will come.', 'Matthew 24:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, guide seekers in %1$s to the gospel through searching YouTube or TikTok today.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Proverbs 8:17', 'prayer-global-porch' ),
                'verse' => _x( 'I love those who love me, and those who seek me find me.', 'Proverbs 8:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, help media producers communicate the gospel in a way that is understandable to the people of %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Deuteronomy 4:29', 'prayer-global-porch' ),
                'verse' => _x( 'But from there, you will seek the LORD your God, and you will find Him if you search for Him with all your heart and all your soul.', 'Deuteronomy 4:29', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, as people seek answers on the internet, please help them find the gospel in %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Luke 11:9', 'prayer-global-porch' ),
                'verse' => _x( 'So I say to you, ask, and it will be given to you; seek, and you will find; knock, and it will be opened to you.', 'Luke 11:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, guide every search on Google for truth in %1$s to find a gospel video.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Jeremiah 29:13', 'prayer-global-porch' ),
                'verse' => _x( 'you will seek Me and find Me when you search for Me with all your heart.', 'Jeremiah 29:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, use Google search to lead people in %1$s to the gospel today.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, supernaturally prepare encounters with the gospel on sites like Facebook and Instagram for the %1$s people living in %2$s.', 'prayer-global-porch' ), $stack['location']['population'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, inspire new kinds of evangelism through social media in %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( '2 Timothy 4:5', 'prayer-global-porch' ),
                'verse' => _x( 'But you, keep your head in all situations, endure hardship, do the work of an evangelist, discharge all the duties of your ministry.', '2 Timothy 4:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, make yourself known to the %1$s people living in %2$s through the internet today.', 'prayer-global-porch' ), $stack['location']['population'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 19:3-4', 'prayer-global-porch' ),
                'verse' => _x( 'They have no speech, they use no words; no sound is heard from them. Yet their voice goes out into all the earth, their words to the ends of the world. In the heavens God has pitched a tent for the sun.', 'Psalm 19:3-4', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, use the media in this country to spread the message of salvation far and wide.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 10:14', 'prayer-global-porch' ),
                'verse' => _x( 'How, then, can they call on the one they have not believed in? And how can they believe in the one of whom they have not heard? And how can they hear without someone preaching to them?', 'Romans 10:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We ask that the media in this region would promote truth, righteousness, and justice, bringing light to the darkness.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 31:8', 'prayer-global-porch' ),
                'verse' => _x( 'Speak up for those who cannot speak for themselves, for the rights of all who are destitute.', 'Proverbs 31:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that Your light would shine brightly in the media of this region, bringing truth and hope to all.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:14', 'prayer-global-porch' ),
                'verse' => _x( 'You are the light of the world. A town built on a hill cannot be hidden.', 'Matthew 5:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your light to shine brightly in the media in this region, bringing truth and hope to those who are searching for answers.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:14', 'prayer-global-porch' ),
                'verse' => _x( 'You are the light of the world. A town built on a hill cannot be hidden.', 'Matthew 5:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May those in the technology field in this region use their skills to create meaningful impact and serve the good of others.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray that Your light would break through the media in this region, dispelling darkness and spreading truth, hope, and righteousness to all who listen, watch, and read.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 43:3', 'prayer-global-porch' ),
                'verse' => _x( 'Send me your light and your faithful care, let them lead me; let them bring me to your holy mountain, to the place where you dwell.', 'Psalm 43:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for Your truth to spread across the media in this region, that it may be a source of hope and light.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 43:3', 'prayer-global-porch' ),
                'verse' => _x( 'Send me your light and your faithful care, let them lead me; let them bring me to your holy mountain, to the place where you dwell.', 'Psalm 43:3', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_safety( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Safety', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, for those in trouble in %1$s of %2$s prompt them to call on you for rescue today.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 91:15', 'prayer-global-porch' ),
                'verse' => _x( 'He will call on me, and I will answer him; I will be with him in trouble, I will deliver him and honor him.', 'Psalm 91:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, for those with enemies and who are afraid in %1$s, call them into your shelter and safety today.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( 'Psalm 61:3', 'prayer-global-porch' ),
                'verse' => _x( 'For you have been a refuge for me, a strong tower from the enemy.', 'Psalm 61:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, be a refuge and strength for the hurting in %1$s today.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Psalm 46:1', 'prayer-global-porch' ),
                'verse' => _x( 'God is our refuge and strength, an ever-present help in trouble.', 'Psalm 46:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, help the stressed and anxious in %1$s know that you care for them today.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Psalm 55:22', 'prayer-global-porch' ),
                'verse' => _x( 'Cast your cares on the Lord and he will sustain you; he will never let the righteous be shaken.', 'Psalm 55:22', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, teach those feeling unsafe in %1$s that they can hide under your wings', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Psalm 91:4', 'prayer-global-porch' ),
                'verse' => _x( 'He will cover you with his feathers, and under his wings you will find refuge; his faithfulness will be your shield and rampart.', 'Psalm 91:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, protect the vulnerable in %1$s from the evil one.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'John 17:15', 'prayer-global-porch' ),
                'verse' => _x( 'My prayer is not that you take them out of the world but that you protect them from the evil one.', 'John 17:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, let the threatened of %1$s know that it is better to trust in you than to trust in humans.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Psalm 118:8', 'prayer-global-porch' ),
                'verse' => _x( 'It is better to take refuge in the Lord than to trust in humans.', 'Psalm 118:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, help the fearful in %1$s to submit to God and resist the devil.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'James 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'Submit yourselves, then, to God. Resist the devil, and he will flee from you.', 'James 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, encourage those who are afraid in %1$s that you are the healer and you are the Savior.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Jeremiah 17:14', 'prayer-global-porch' ),
                'verse' => _x( 'Heal me, Lord, and I will be healed; save me and I will be saved, for you are the one I praise.', 'Jeremiah 17:14', 'prayer-global-porch' ),
            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( 'Psalm 145:18-19', 'prayer-global-porch' ),
//                'verse' => _x( 'The Lord is near to all who call on him, to all who call on him in truth. He fulfills the desires of those who fear him; he hears their cry and saves them.', 'Psalm 145:18-19', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( 'Psalms 107:13-14', 'prayer-global-porch' ),
//                'verse' => _x( 'Then they cried to the Lord in their trouble, and he saved them from their distress. He brought them out of darkness, the utter darkness, and broke away their chains.', 'Psalms 107:13-14', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( 'Psalm 34:10', 'prayer-global-porch' ),
//                'verse' => _x( 'The lions may grow weak and hungry, but those who seek the Lord lack no good thing.', 'Psalm 34:10', 'prayer-global-porch' ),
//            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for your protection over the persecuted church in this region, that they may stand firm in their faith.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for your divine protection over the elderly in this country, that they would feel your love and care.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age and gray hairs I am he, I am he who will sustain you.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those facing natural disasters in this region, that you would provide protection and restore hope to those affected.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 46:1', 'prayer-global-porch' ),
                'verse' => _x( 'God is our refuge and strength, an ever-present help in trouble.', 'Psalm 46:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for your protection and provision for the elderly in this region, that they may experience your care and comfort.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'Gray hair is a crown of splendor; it is attained in the way of righteousness.', 'Proverbs 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the refugees in this region, that they would find safety, hope, and new beginnings in you.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:35', 'prayer-global-porch' ),
                'verse' => _x( 'For I was hungry and you gave me something to eat, I was thirsty and you gave me something to drink, I was a stranger and you invited me in,', 'Matthew 25:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for the displaced people in this region, that they would find a place of safety, comfort, and belonging.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:35', 'prayer-global-porch' ),
                'verse' => _x( 'For I was hungry and you gave me something to eat, I was thirsty and you gave me something to drink, I was a stranger and you invited me in,', 'Matthew 25:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for your protection over children in this region, that they would grow up in the knowledge of your love.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the homeless in this region, that they would find shelter, comfort, and provision in you.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 9:9', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is a refuge for the oppressed, a stronghold in times of trouble.', 'Psalm 9:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those facing natural disasters in this region, that your mercy and provision would cover them during this time.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those struggling with mental health in this region, that they would find peace and healing in your presence.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are homeless in this region, that they would find shelter and care, both physically and spiritually.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May those without homes in this region find shelter, provision, and community, experiencing your love.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, protect the believers in this country from harm and keep them strong in their faith.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:2', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is my refuge and my fortress, my God, in whom I trust.', 'Psalm 91:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for protection for new believers in this country as they grow in their faith and face opposition.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for your protection over this region, that you would keep it safe from harm and danger.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 121:7', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will keep you from all harm—He will watch over your life.', 'Psalm 121:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for your hand of protection over the children of this region, shielding them from harm and guiding them in your truth.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 121:8', 'prayer-global-porch' ),
                'verse' => _x( 'he Lord will watch over your coming and going both now and forevermore.', 'Psalm 121:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the safety of those traveling in this region, that they may be protected from harm and reach their destinations safely.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 121:8', 'prayer-global-porch' ),
                'verse' => _x( 'he Lord will watch over your coming and going both now and forevermore.', 'Psalm 121:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for your protection over the infrastructure in this region, that it would serve the needs of the people.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 121:8', 'prayer-global-porch' ),
                'verse' => _x( 'he Lord will watch over your coming and going both now and forevermore.', 'Psalm 121:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for your protection over the borders of this country, that peace would reign and security would be restored.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 121:8', 'prayer-global-porch' ),
                'verse' => _x( 'he Lord will watch over your coming and going both now and forevermore.', 'Psalm 121:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We ask for your protection and wisdom for the elderly in this region, that they may be honored and cherished.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'The silver-haired head is a crown of glory if it is found in the way of righteousness.', 'Proverbs 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, please protect and strengthen those who face persecution for their faith in this country.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness, for theirs is the kingdom of heaven.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for courage for those who are persecuted for their faith in this country.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness, for theirs is the kingdom of heaven.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for Your protection over families in this country, that they may be rooted in Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for Your hand of protection over the children in this country, that they may grow in Your knowledge and love.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 127:3', 'prayer-global-porch' ),
                'verse' => _x( 'Children are a heritage from the Lord, offspring a reward from him.', 'Psalm 127:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the children of this region to grow in Your wisdom and to experience Your love and protection.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 127:3', 'prayer-global-porch' ),
                'verse' => _x( 'Children are a heritage from the Lord, offspring a reward from him.', 'Psalm 127:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for Your protection over the children in this region, that they may grow up strong in faith and spirit, walking in Your ways.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'These commandments that I give you today are to be on your hearts. Impress them on your children. Talk about them when you sit at home and when you walk along the road, when you lie down and when you get up.', 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the health and well-being of those in this region, that You would protect them from disease and injury.', 'prayer-global-porch' ),
                'reference' => __( 'Exodus 15:26', 'prayer-global-porch' ),
                'verse' => _x( 'He said, ‘If you listen carefully to the Lord your God and do what is right in his eyes, if you pay attention to his commands and keep all his decrees, I will not bring on you any of the diseases I brought on the Egyptians, for I am the Lord, who heals you.’', 'Exodus 15:26', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the homeless families in this region, that You would provide them with safety, stability, and hope.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 41:10', 'prayer-global-porch' ),
                'verse' => _x( 'So do not fear, for I am with you; do not be dismayed, for I am your God. I will strengthen you and help you; I will uphold you with my righteous right hand.', 'Isaiah 41:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the homeless in this region, that they would find shelter, safety, and a community of care.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 58:7', 'prayer-global-porch' ),
                'verse' => _x( 'Is it not to share your food with the hungry and to provide the poor wanderer with shelter—when you see the naked, to clothe them, and not to turn away from your own flesh and blood?', 'Isaiah 58:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the homeless in this region, that You would provide them with shelter, food, and hope for a better future.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 58:7', 'prayer-global-porch' ),
                'verse' => _x( 'Is it not to share your food with the hungry and to provide the poor wanderer with shelter—when you see the naked, to clothe them, and not to turn away from your own flesh and blood?', 'Isaiah 58:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for those experiencing homelessness in this region, that they would find shelter, comfort, and the hope of the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 58:7', 'prayer-global-porch' ),
                'verse' => _x( 'Is it not to share your food with the hungry and to provide the poor wanderer with shelter—when you see the naked, to clothe them, and not to turn away from your own flesh and blood?', 'Isaiah 58:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the immigrants in this region, that they would be welcomed and find peace and security.', 'prayer-global-porch' ),
                'reference' => __( 'Leviticus 19:34', 'prayer-global-porch' ),
                'verse' => _x( 'The foreigner residing among you must be treated as your native-born. Love them as yourself, for you were foreigners in Egypt. I am the Lord your God.', 'Leviticus 19:34', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the refugees in this region, that You would grant them a place of safety and support in their time of need.', 'prayer-global-porch' ),
                'reference' => __( 'Leviticus 19:34', 'prayer-global-porch' ),
                'verse' => _x( 'The foreigner residing among you must be treated as your native-born. Love them as yourself, for you were foreigners in Egypt. I am the Lord your God.', 'Leviticus 19:34', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the children in this region, that they would be protected from harm and grow up in the knowledge of Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 19:14', 'prayer-global-porch' ),
                'verse' => _x( 'Jesus said, Let the little children come to me, and do not hinder them, for the kingdom of heaven belongs to such as these.', 'Matthew 19:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for Your protection over the children in this region, keeping them safe from harm and filling them with Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 19:14', 'prayer-global-porch' ),
                'verse' => _x( 'Jesus said, Let the little children come to me, and do not hinder them, for the kingdom of heaven belongs to such as these.', 'Matthew 19:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for Your protection over the children in this region, that they would grow in wisdom and knowledge of You.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 19:14', 'prayer-global-porch' ),
                'verse' => _x( 'Jesus said, Let the little children come to me, and do not hinder them, for the kingdom of heaven belongs to such as these.', 'Matthew 19:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for Your protection over the children in this region, that they would grow up in a safe environment surrounded by love.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 19:14', 'prayer-global-porch' ),
                'verse' => _x( 'Jesus said, Let the little children come to me, and do not hinder them, for the kingdom of heaven belongs to such as these.', 'Matthew 19:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask for protection over the children in this region, that they may grow in safety and learn to love You with all their hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 19:14', 'prayer-global-porch' ),
                'verse' => _x( 'Jesus said, Let the little children come to me, and do not hinder them, for the kingdom of heaven belongs to such as these.', 'Matthew 19:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those facing persecution for their faith in this region, that You would give them strength to stand firm in their convictions.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness, for theirs is the kingdom of heaven.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are facing persecution for their faith in this region, that You would strengthen them and fill them with boldness.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness, for theirs is the kingdom of heaven.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are facing persecution in this region, that You would strengthen them and give them courage to remain faithful.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness, for theirs is the kingdom of heaven.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those enduring persecution in this region. Grant them courage, strength, and unwavering faith as they stand firm in You.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness, for theirs is the kingdom of heaven.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those facing persecution in this region, that You would give them the strength to endure and remain faithful.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness, for theirs is the kingdom of heaven.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those working in law enforcement in this region, that they would act justly and protect the vulnerable.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 31:8-9', 'prayer-global-porch' ),
                'verse' => _x( 'Speak up for those who cannot speak for themselves, for the rights of all who are destitute. Speak up and judge fairly; defend the rights of the poor and needy.', 'Proverbs 31:8-9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for Your protection over the missionaries in this region, that they would be kept safe and filled with Your Spirit as they serve.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 121:7', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will keep you from all harm—he will watch over your life;', 'Psalm 121:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for Your protection over the workers in this region, that You would guard them and provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 121:7', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will keep you from all harm—he will watch over your life;', 'Psalm 121:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the safety and protection of children in this region, that they may grow up in peace and security.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 121:7', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will keep you from all harm—he will watch over your life;', 'Psalm 121:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would protect those traveling in this region, keeping them safe and guiding their paths.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 121:8', 'prayer-global-porch' ),
                'verse' => _x( 'the Lord will watch over your coming and goingboth now and forevermore.', 'Psalm 121:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask for protection and provision for the homeless in this region, that they would find refuge in Your care and experience Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 14:6', 'prayer-global-porch' ),
                'verse' => _x( 'You evildoers frustrate the plans of the poor, but the Lord is their refuge.', 'Psalm 14:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the military personnel in this region, that You would protect them and give them strength in their duties.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 144:1', 'prayer-global-porch' ),
                'verse' => _x( 'Praise be to the Lord my Rock, who trains my hands for war, my fingers for battle.', 'Psalm 144:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your protection over the children who are being trafficked in this region, and that You would bring justice and freedom to them.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 82:4', 'prayer-global-porch' ),
                'verse' => _x( 'Rescue the weak and the needy; deliver them from the hand of the wicked.', 'Psalm 82:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your hand of protection on the students in this region, that they would be safe in their schools and protected from harm.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:11', 'prayer-global-porch' ),
                'verse' => _x( 'For he will command his angels concerning you to guard you in all your ways;', 'Psalm 91:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your protection for the missionaries in this region, that You would keep them safe and guide them in their efforts to reach the lost.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:11', 'prayer-global-porch' ),
                'verse' => _x( 'For he will command his angels concerning you to guard you in all your ways;', 'Psalm 91:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your protection over the children in this region, that they would be shielded from harm and grow up in the fear of the Lord.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:11', 'prayer-global-porch' ),
                'verse' => _x( 'For he will command his angels concerning you to guard you in all your ways;', 'Psalm 91:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your protection over the children in this region, that they would grow up in safety, joy, and love.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:11', 'prayer-global-porch' ),
                'verse' => _x( 'For he will command his angels concerning you to guard you in all your ways;', 'Psalm 91:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we lift up the healthcare workers in this region, asking for Your protection over them and Your guidance as they serve and care for those in need.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:11', 'prayer-global-porch' ),
                'verse' => _x( 'For he will command his angels concerning you to guard you in all your ways;', 'Psalm 91:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the military and first responders in this region, that You would protect them and give them strength to serve.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:11', 'prayer-global-porch' ),
                'verse' => _x( 'For he will command his angels concerning you to guard you in all your ways;', 'Psalm 91:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for Your protection over the children in this region, that they may grow up in safe environments where they can flourish.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:11', 'prayer-global-porch' ),
                'verse' => _x( 'For he will command his angels concerning you to guard you in all your ways;', 'Psalm 91:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your protection over the families in this region from any harm or danger.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:4', 'prayer-global-porch' ),
                'verse' => _x( 'He will cover you with his feathers, and under his wings you will find refuge; his faithfulness will be your shield and rampart.', 'Psalm 91:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your protection over the families in this region, that they may remain strong in faith and love.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:4', 'prayer-global-porch' ),
                'verse' => _x( 'He will cover you with his feathers, and under his wings you will find refuge; his faithfulness will be your shield and rampart.', 'Psalm 91:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the missionaries in this region, that You would protect them and give them strength to continue the work of spreading Your word.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 10:15', 'prayer-global-porch' ),
                'verse' => _x( 'How beautiful are the feet of those who bring good news!', 'Romans 10:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your peace to reign in the schools of this region, that students and teachers would experience a safe and loving environment.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 12:18', 'prayer-global-porch' ),
                'verse' => _x( 'If it is possible, as far as it depends on you, live at peace with everyone.', 'Romans 12:18', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_political_stability( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Political Stability', 'prayer-global-porch' );
        $current_templates = [];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the marketplace in this region, that it would be a place where honesty, integrity, and fairness are upheld.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:8', 'prayer-global-porch' ),
                'verse' => _x( 'Better a little with righteousness than much gain with injustice.', 'Proverbs 16:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for justice to flow in this region, that all people may experience fairness, dignity, and respect.', 'prayer-global-porch' ),
                'reference' => __( 'Amos 5:24', 'prayer-global-porch' ),
                'verse' => _x( 'But let justice roll on like a river, righteousness like a never-failing stream!', 'Amos 5:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for your mercy on the leaders of this region, that they would rule justly and seek your wisdom in all decisions.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from His mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the leaders in this region come to know you personally, and lead with righteousness and wisdom from above.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that you would bless the leaders of this region with wisdom, discernment, and compassion as they make decisions that affect the lives of many.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the leaders in this region—give them wisdom, humility, and courage to lead justly.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for your justice to prevail in this region, that the oppressed may be freed and the vulnerable protected.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 1:17', 'prayer-global-porch' ),
                'verse' => _x( 'Learn to do right; seek justice. Defend the oppressed. Take up the cause of the fatherless; plead the case of the widow.', 'Isaiah 1:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we lift up the marginalized and oppressed in this region, praying for justice and compassion to rise.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 1:17', 'prayer-global-porch' ),
                'verse' => _x( 'Learn to do right; seek justice. Defend the oppressed. Take up the cause of the fatherless; plead the case of the widow.', 'Isaiah 1:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for your justice to prevail in this region, that corruption and injustice would be eradicated.', 'prayer-global-porch' ),
                'reference' => __( 'Amos 5:24', 'prayer-global-porch' ),
                'verse' => _x( 'Let justice roll on like a river, righteousness like a never-failing stream!', 'Amos 5:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for your grace to cover the leaders in this region, that they would lead with integrity and righteousness.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 14:34', 'prayer-global-porch' ),
                'verse' => _x( 'Righteousness exalts a nation, but sin condemns any people.', 'Proverbs 14:34', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for your provision and guidance for businesses in this region, that they may prosper and bless their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 10:22', 'prayer-global-porch' ),
                'verse' => _x( 'The blessing of the Lord brings wealth, without painful toil for it.', 'Proverbs 10:22', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the economy in this region, that you would provide stability and prosperity for all.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 10:22', 'prayer-global-porch' ),
                'verse' => _x( 'The blessing of the Lord brings wealth, without painful toil for it.', 'Proverbs 10:22', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those in positions of influence in this country, that they would use their power for good.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 23:11', 'prayer-global-porch' ),
                'verse' => _x( 'The greatest among you will be your servant.', 'Matthew 23:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May justice, mercy, and righteousness guide the law enforcement in this region, enabling them to serve with integrity.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 99:4', 'prayer-global-porch' ),
                'verse' => _x( 'The king is a lover of justice; You have established equity; You have executed justice and righteousness in Jacob.', 'Psalm 99:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray that you would raise up leaders in this country who will guide with wisdom and compassion.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:1', 'prayer-global-porch' ),
                'verse' => _x( 'In the Lord’s hand the king’s heart is a stream of water that he channels toward all who please him.', 'Proverbs 21:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the community leaders in this region, that they would lead with integrity and humility, seeking your guidance.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:1', 'prayer-global-porch' ),
                'verse' => _x( 'In the Lord’s hand the king’s heart is a stream of water that he channels toward all who please him.', 'Proverbs 21:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those in positions of authority in this country to lead with justice and integrity.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:1', 'prayer-global-porch' ),
                'verse' => _x( 'In the Lord’s hand the king’s heart is a stream of water that he channels toward all who please him.', 'Proverbs 21:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We ask that you guide the community leaders in this region to lead with integrity and humility, seeking your wisdom.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:1', 'prayer-global-porch' ),
                'verse' => _x( 'In the Lord’s hand the king’s heart is a stream of water that he channels toward all who please him.', 'Proverbs 21:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for wisdom and justice to guide those in positions of authority in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:1', 'prayer-global-porch' ),
                'verse' => _x( 'In the Lord’s hand the king’s heart is a stream of water that he channels toward all who please him.', 'Proverbs 21:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the leaders in this region, that they may act justly and with compassion for the people they lead.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 11:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord detests the use of dishonest scales, but He delights in accurate weights.', 'Proverbs 11:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for your peace to surround the leaders of this country, that they would seek your guidance in their decisions.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 29:11', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord gives strength to his people; the Lord blesses his people with peace.', 'Psalm 29:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for peace in the hearts of those in this region, where unrest and uncertainty abound. Bring calm amidst the chaos.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 29:11', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord gives strength to his people; the Lord blesses his people with peace.', 'Psalm 29:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the economy in this region, that you would provide for families, businesses, and communities.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May the economy in this region flourish, and may families, businesses, and communities receive your provision.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the economy of this region, that you would provide for those in need and strengthen local businesses.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the communities suffering from racial tensions in this region, that your love would bring reconciliation and peace.', 'prayer-global-porch' ),
                'reference' => __( 'Galatians 3:28', 'prayer-global-porch' ),
                'verse' => _x( 'There is neither Jew nor Gentile, neither slave nor free, nor is there male and female, for you are all one in Christ Jesus.', 'Galatians 3:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, let your love break down walls and divisions between different groups in this country.', 'prayer-global-porch' ),
                'reference' => __( 'Galatians 3:28', 'prayer-global-porch' ),
                'verse' => _x( 'There is neither Jew nor Gentile, neither slave nor free, nor is there male and female, for you are all one in Christ Jesus.', 'Galatians 3:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for safety and growth in the schools of this region, that students may receive a solid foundation of knowledge.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Train up a child in the way he should go, and when he is old he will not depart from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray that the government leaders in this country would lead with justice and integrity.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 29:2', 'prayer-global-porch' ),
                'verse' => _x( 'When the righteous thrive, the people rejoice; when the wicked rule, the people groan.', 'Proverbs 29:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the government officials in this region, that they would seek righteousness and justice for all.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 29:2', 'prayer-global-porch' ),
                'verse' => _x( 'When the righteous thrive, the people rejoice; when the wicked rule, the people groan.', 'Proverbs 29:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the government in this country, that they would rule with justice and righteousness.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 29:2', 'prayer-global-porch' ),
                'verse' => _x( 'When the righteous thrive, the people rejoice; when the wicked rule, the people groan.', 'Proverbs 29:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the leaders in this region, that they would govern with wisdom, justice, and integrity.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 2:1-2', 'prayer-global-porch' ),
                'verse' => _x( 'I urge, then, first of all, that petitions, prayers, intercession and thanksgiving be made for all people— for kings and all those in authority, that we may live peaceful and quiet lives in all godliness and holiness.', '1 Timothy 2:1-2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the government officials in this region, that they would lead with a heart of service and a desire to promote peace and justice.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 2:1-2', 'prayer-global-porch' ),
                'verse' => _x( 'I urge, then, first of all, that petitions, prayers, intercession and thanksgiving be made for all people— for kings and all those in authority, that we may live peaceful and quiet lives in all godliness and holiness.', '1 Timothy 2:1-2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would bring reconciliation to the divided communities in this region, that they would experience peace and unity in Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 2:14', 'prayer-global-porch' ),
                'verse' => _x( 'For he himself is our peace, who has made the two groups one and has destroyed the barrier, the dividing wall of hostility.', 'Ephesians 2:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for unity among the ethnic groups in this region, that division would be replaced by peace and understanding.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 2:14', 'prayer-global-porch' ),
                'verse' => _x( 'For he himself is our peace, who has made the two groups one and has destroyed the barrier, the dividing wall of hostility.', 'Ephesians 2:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May the ethnic groups in this region be united in peace, overcoming divisions with understanding and love.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 2:14', 'prayer-global-porch' ),
                'verse' => _x( 'For he himself is our peace, who has made the two groups one and has destroyed the barrier, the dividing wall of hostility.', 'Ephesians 2:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for unity among different ethnic groups in this region, that there would be peace and understanding.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 2:14', 'prayer-global-porch' ),
                'verse' => _x( 'For he himself is our peace, who has made the two groups one and has destroyed the barrier, the dividing wall of hostility.', 'Ephesians 2:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the government in this region, that it would work for justice, peace, and the welfare of the people.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 1:17', 'prayer-global-porch' ),
                'verse' => _x( 'Learn to do right; seek justice. Defend the oppressed. Take up the cause of the fatherless; plead the case of the widow.', 'Isaiah 1:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the government leaders in this region, that they would pursue righteousness and justice for every person they serve.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 1:17', 'prayer-global-porch' ),
                'verse' => _x( 'Learn to do right; seek justice. Defend the oppressed. Take up the cause of the fatherless; plead the case of the widow.', 'Isaiah 1:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those in this region suffering from injustice, that they would find justice and restoration through Your hand.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 1:17', 'prayer-global-porch' ),
                'verse' => _x( 'Learn to do right; seek justice. Defend the oppressed. Take up the cause of the fatherless; plead the case of the widow.', 'Isaiah 1:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for peace to reign in this region, especially in areas that have known violence and conflict.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 26:3', 'prayer-global-porch' ),
                'verse' => _x( 'You will keep in perfect peace those whose minds are steadfast, because they trust in you.', 'Isaiah 26:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the peacekeepers in this region, that they would have wisdom, strength, and courage as they work for justice and peace.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:9', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are the peacemakers, for they will be called children of God.', 'Matthew 5:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would bring about reconciliation between individuals and communities in this region that are divided by conflict or hatred.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:9', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are the peacemakers, for they will be called children of God.', 'Matthew 5:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for peace to reign in this region, that divisions and conflicts would be healed by Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for Your Spirit to move in the hearts of leaders in this region, guiding them to make decisions that lead to peace and prosperity for all.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:9', 'prayer-global-porch' ),
                'verse' => _x( 'In their hearts humans plan their course, but the Lord establishes their steps.', 'Proverbs 16:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for Your Spirit to move in the political leaders of this region, that they would act with integrity and wisdom.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the leaders in this region, that they would have the wisdom to make decisions that lead to peace and prosperity for all.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the leaders in this region, that they would be wise and compassionate in their decision-making for the good of all people.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would empower the leaders in this region to make decisions that reflect Your righteousness and wisdom.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:9', 'prayer-global-porch' ),
                'verse' => _x( 'Then you will understand what is right and just and fair—every good path.', 'Proverbs 2:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the leaders of the nation of this country, that they would govern with integrity and wisdom, seeking the welfare of all people.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:9', 'prayer-global-porch' ),
                'verse' => _x( 'Then you will understand what is right and just and fair—every good path.', 'Proverbs 2:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would soften the hearts of the leaders in this region to act justly and with compassion toward the people.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:1', 'prayer-global-porch' ),
                'verse' => _x( 'In the Lord’s hand the king’s heart is a stream of water that he channels toward all who please him.', 'Proverbs 21:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask for Your Spirit to guide the leaders of this region in their decisions, giving them a heart of justice and mercy.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:1', 'prayer-global-porch' ),
                'verse' => _x( 'In the Lord’s hand the king’s heart is a stream of water that he channels toward all who please him.', 'Proverbs 21:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those in this region who are facing legal troubles, that You would provide them with justice and favor in the courts.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:15', 'prayer-global-porch' ),
                'verse' => _x( 'When justice is done, it brings joy to the righteous but terror to evildoers.', 'Proverbs 21:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would raise up leaders in this region who will lead with righteousness and fear of the Lord.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 29:2', 'prayer-global-porch' ),
                'verse' => _x( 'When the righteous thrive, the people rejoice; when the wicked rule, the people groan.', 'Proverbs 29:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the government leaders in this region, that they would lead with integrity, wisdom, and justice for all people.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 29:2', 'prayer-global-porch' ),
                'verse' => _x( 'When the righteous thrive, the people rejoice; when the wicked rule, the people groan.', 'Proverbs 29:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your wisdom for the government leaders in this region, that they would lead with integrity and make decisions that honor You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 29:2', 'prayer-global-porch' ),
                'verse' => _x( 'When the righteous thrive, the people rejoice; when the wicked rule, the people groan.', 'Proverbs 29:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the community leaders in this region, that they would act with integrity, seeking the well-being of all people.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 29:2', 'prayer-global-porch' ),
                'verse' => _x( 'When the righteous thrive, the people rejoice; when the wicked rule, the people groan.', 'Proverbs 29:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the government officials in this region, that they may lead with integrity and seek justice for the oppressed.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 29:2', 'prayer-global-porch' ),
                'verse' => _x( 'When the righteous thrive, the people rejoice; when the wicked rule, the people groan.', 'Proverbs 29:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for peace and stability in the government of this region, that it may reflect Your justice and righteousness.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 33:5', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord loves righteousness and justice; the earth is full of his unfailing love.', 'Psalm 33:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those affected by the rise in violence in this region, that You would bring peace and safety to their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:14', 'prayer-global-porch' ),
                'verse' => _x( 'Turn from evil and do good; seek peace and pursue it.', 'Psalm 34:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the nations of the world, that peace and justice would prevail, and that Your name would be glorified in all places.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 46:9', 'prayer-global-porch' ),
                'verse' => _x( 'He makes wars cease to the ends of the earth. He breaks the bow and shatters the spear; he burns the shields with fire.', 'Psalm 46:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the government in this country, that they would lead with justice and integrity, upholding righteousness in all their decisions.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 72:1-2', 'prayer-global-porch' ),
                'verse' => _x( 'Endow the king with your justice, O God, the royal son with your righteousness. He will judge your people in righteousness, your afflicted ones with justice.', 'Psalm 72:1-2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the peace of this region, that Your love and peace would bring harmony among its people.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 12:18', 'prayer-global-porch' ),
                'verse' => _x( 'If it is possible, as far as it depends on you, live at peace with everyone.', 'Romans 12:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask for peace and reconciliation to be present in the communities of this region, where there is division and conflict.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 12:18', 'prayer-global-porch' ),
                'verse' => _x( 'If it is possible, as far as it depends on you, live at peace with everyone.', 'Romans 12:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the communities in this region, that You would bring peace, unity, and understanding among all people.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 14:19', 'prayer-global-porch' ),
                'verse' => _x( 'Let us therefore make every effort to do what leads to peace and to mutual edification.', 'Romans 14:19', 'prayer-global-porch' ),
            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( 'Proverbs 28:5', 'prayer-global-porch' ),
//                'verse' => _x( 'Evil men do not understand justice, But those who seek the LORD understand all things.', 'Proverbs 28:5', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( 'Proverbs 2:3-6', 'prayer-global-porch' ),
//                'verse' => _x( 'Indeed, if you call out for insight and cry aloud for understanding, and if you look for it as for silver and search for it as for hidden treasure, then you will understand the fear of the Lord and find the knowledge of God. For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:3-6', 'prayer-global-porch' ),
//            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_demographic_feature_total_population( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Population', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => __( 'Far from God', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Father, you desire the people in %1$s of %2$s who are far from you to hear about you.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Romans 15:21', 'prayer-global-porch' ),
                'verse' => _x( '"Those who were not told about him will see, and those who have not heard will understand."', 'Romans 15:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'There are %1$s people living in %2$s of %3$s. Only about %4$s might be believers.', 'prayer-global-porch' ), $stack['location']['population'], $stack['location']['admin_level_title'], $stack['location']['name'], $stack['location']['believers'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( '%1$s of %2$s has (about) %3$s people who know Jesus, %4$s people who know about him culturally, and %5$s people who are far from Jesus.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'], $stack['location']['believers'], $stack['location']['christian_adherents'], $stack['location']['non_christians'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Pour your Spirit out on the %1$s citizens of %2$s, so that they might know your name and the name of your Son.', 'prayer-global-porch' ), $stack['location']['population'], $stack['location']['full_name'] ),
                'reference' => __( 'Joel 2:28', 'prayer-global-porch' ),
                'verse' => _x( 'And afterward, I will pour out my Spirit on all people. your sons and daughters will prophesy, your old men will dream dreams, your young men will see visions.', 'Joel 2:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, we suspect there is 1 believer for every %1$s neighbors who are far from you in %2$s. Please, give courage and opportunity to your children to speak boldly.', 'prayer-global-porch' ), $stack['location']['lost_per_believer'], $stack['location']['name'] ),
                'reference' => __( 'Ephesians 6:19', 'prayer-global-porch' ),
                'verse' => _x( 'Pray also for me, that whenever I speak, words may be given me so that I will fearlessly make known the mystery of the gospel.', 'Ephesians 6:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, help the people of %1$s to discover the essence of being a disciple, making disciples, and how to plant churches that multiply.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, you know every soul, and you know who are yours and who are yet to be yours out of the %1$s people living in %2$s. Please, call your lost sheep to yourself.', 'prayer-global-porch' ), $stack['location']['population'], $stack['location']['full_name'] ),
                'reference' => __( 'Ezekiel 36:24', 'prayer-global-porch' ),
                'verse' => _x( 'For I will take you out of the nations; I will gather you from all the countries and bring you back into your own land.', 'Ezekiel 36:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, bring yourself glory in %1$s. Through your servants plant %2$s new churches that love you, love one another, and make disciples this year.', 'prayer-global-porch' ), $stack['location']['name'], $stack['location']['new_churches_needed'] ),
                'reference' => __( 'Habakkuk 2:14', 'prayer-global-porch' ),
                'verse' => _x( 'For the earth will be filled with the knowledge of the glory of the LORD as the waters cover the sea.', 'Habakkuk 2:14', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the education system in this region, that children may be taught truth, wisdom, and respect.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the farmers in this region, that you would bless their labor with abundant harvests.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 24:1', 'prayer-global-porch' ),
                'verse' => _x( 'The earth is the Lord’s, and everything in it, the world, and all who live in it;', 'Psalm 24:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Let the people of this region be stewards of the earth, reflecting your care for creation through responsible environmental practices.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 24:1', 'prayer-global-porch' ),
                'verse' => _x( 'The earth is the Lord’s, and everything in it, the world, and all who live in it;', 'Psalm 24:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for healing for the land in this region, where environmental destruction has caused harm. May it be restored to health.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 24:1', 'prayer-global-porch' ),
                'verse' => _x( 'The earth is the Lord’s, and everything in it, the world, and all who live in it;', 'Psalm 24:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the environment in this region, that people would steward the earth with wisdom and care, reflecting your creativity.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 24:1', 'prayer-global-porch' ),
                'verse' => _x( 'The earth is the Lord’s, and everything in it, the world, and all who live in it;', 'Psalm 24:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we thank you for the beauty and diversity of this region. May the people see your creation and come to know you as Creator.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 19:1', 'prayer-global-porch' ),
                'verse' => _x( 'The heavens declare the glory of God; the skies proclaim the work of his hands.', 'Psalm 19:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we lift up the farmers in this region, that you would bless their work and provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 67:6', 'prayer-global-porch' ),
                'verse' => _x( 'The land yields its harvest; God, our God, blesses us.', 'Psalm 67:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for the fishermen and women in this region, that their work would be fruitful and sustain their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:11', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will bless you with abundant prosperity, in the fruit of your womb.', 'Deuteronomy 28:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that your peace would rest upon the marriages in this region, bringing healing and unity.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 10:9', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore what God has joined together, let no one separate.', 'Mark 10:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the workers in this region that they may find satisfaction in their labor and be treated with dignity and respect.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May the workers in this region experience purpose in their work and be honored with dignity and respect in every task they do.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May those working in technology in this region use their gifts to bring positive change and benefit to others.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would bless the workers in this country, that their labor would bring honor to You.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May those laboring in agriculture in this region be blessed with plentiful harvests and find deep purpose in the work of their hands.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 65:11', 'prayer-global-porch' ),
                'verse' => _x( 'You crown the year with Your goodness, and Your paths drip with abundance.', 'Psalm 65:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray Your blessing over the workers in this country. May their efforts be fruitful and carried out with excellence, bringing glory to Your name through all they do.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 10:31', 'prayer-global-porch' ),
                'verse' => _x( 'So whether you eat or drink or whatever you do, do it all for the glory of God.', '1 Corinthians 10:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would heal the land of this region, bringing restoration, health, and hope to every community.', 'prayer-global-porch' ),
                'reference' => __( '2 Chronicles 7:14', 'prayer-global-porch' ),
                'verse' => _x( 'if my people, who are called by my name, will humble themselves and pray and seek my face and turn from their wicked ways, then I will hear from heaven, and I will forgive their sin and will heal their land.', '2 Chronicles 7:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would heal the land of this region, bringing restoration and spiritual revival.', 'prayer-global-porch' ),
                'reference' => __( '2 Chronicles 7:14', 'prayer-global-porch' ),
                'verse' => _x( 'if my people, who are called by my name, will humble themselves and pray and seek my face and turn from their wicked ways, then I will hear from heaven, and I will forgive their sin and will heal their land.', '2 Chronicles 7:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May those working in agriculture in this region experience abundant harvests and a strong sense of purpose in their labor.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 9:10', 'prayer-global-porch' ),
                'verse' => _x( 'Now he who supplies seed to the sower and bread for food will also supply and increase your store of seed and will enlarge the harvest of your righteousness.', '2 Corinthians 9:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for peace in this region, that Your peace would reign in every heart and in every home.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:9', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are the peacemakers, for they will be called children of God.', 'Matthew 5:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, let Your Kingdom take root and flourish in every area of life in this region—from leadership and education to the marketplace and every household.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 1:16', 'prayer-global-porch' ),
                'verse' => _x( 'For in him all things were created: things in heaven and on earth, visible and invisible, whether thrones or powers or rulers or authorities; all things have been created through him and for him.', 'Colossians 1:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for Your peace to reign over marriages in this region, healing any brokenness and bringing harmony into their relationships.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:14', 'prayer-global-porch' ),
                'verse' => _x( 'And over all these virtues put on love, which binds them all together in perfect unity.', 'Colossians 3:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are unemployed in this region, that You would open doors for them to find meaningful work.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the businesses in this region, that they would be guided by ethical principles and seek to serve others.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the business owners in this region, that they would honor You in their work and use their resources for good.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:3', 'prayer-global-porch' ),
                'verse' => _x( 'Commit to the Lord whatever you do, and he will establish your plans.', 'Proverbs 16:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May the small businesses in this region thrive and contribute to the growth and well-being of their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:3', 'prayer-global-porch' ),
                'verse' => _x( 'Commit to the Lord whatever you do, and he will establish your plans.', 'Proverbs 16:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the farmers in this region, that You would bless their work and provide abundant harvests.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would bless the farmers and those in agriculture in this region, providing for their needs and strengthening their hands for the work.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we lift up the farmers in this region, asking You to bless their labor and grant them bountiful harvests.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the farmers and agricultural workers in this region, that You would bless their efforts and provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the farmers in this region, that their crops would be plentiful and their labor fruitful.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the farmers and agricultural workers in this region, that You would bless their crops and provide for their families.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the farmers in this region, that their crops may prosper and provide for their families and communities.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:8', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will send a blessing on your barns and on everything you put your hand to. The Lord your God will bless you in the land he is giving you.', 'Deuteronomy 28:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the teachers in this region, that they would inspire the next generation with truth and love.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'These commandments that I give you today are to be on your hearts. Impress them on your children. Talk about them when you sit at home and when you walk along the road, when you lie down and when you get up.', 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the small business owners in this region, that You would bless their efforts and provide them with opportunities to succeed.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 8:18', 'prayer-global-porch' ),
                'verse' => _x( 'But remember the Lord your God, for it is he who gives you the ability to produce wealth.', 'Deuteronomy 8:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the young professionals in this region, that they would find fulfillment in their work and balance in their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Ecclesiastes 3:13', 'prayer-global-porch' ),
                'verse' => _x( 'That each of them may eat and drink, and find satisfaction in all their toil—this is the gift of God.', 'Ecclesiastes 3:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the families in this region, that they would be united in love and honor for each other.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the families in this region, that they would experience Your provision and care, and draw closer to one another.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:33', 'prayer-global-porch' ),
                'verse' => _x( 'However, each one of you also must love his wife as he loves himself, and the wife must respect her husband.', 'Ephesians 5:33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Bless those working to provide clean water and sanitation in this region, may their efforts lead to long-lasting change.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:35', 'prayer-global-porch' ),
                'verse' => _x( 'For I was hungry and you gave me something to eat, I was thirsty and you gave me something to drink, I was a stranger and you invited me in,', 'Matthew 25:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the farmers and agricultural workers in this region, that they would be blessed with fruitful harvests and sustainable livelihoods.', 'prayer-global-porch' ),
                'reference' => __( 'Galatians 6:9', 'prayer-global-porch' ),
                'verse' => _x( 'Let us not become weary in doing good, for at the proper time we will reap a harvest if we do not give up.', 'Galatians 6:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the environment in this region, that people would be good stewards of Your creation and care for the earth as You intended.', 'prayer-global-porch' ),
                'reference' => __( 'Genesis 2:15', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord God took the man and put him in the Garden of Eden to work it and take care of it.', 'Genesis 2:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the elderly in this region, that You would provide them with comfort, health, and community in their later years.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age and gray hairs I am he, I am he who will sustain you. I have made you and I will carry you; I will sustain you and I will rescue you.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the elderly in this region, that they would feel valued and loved by their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age and gray hairs I am he, I am he who will sustain you. I have made you and I will carry you; I will sustain you and I will rescue you.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the elderly in this region, that they would be treated with dignity, honor, and love, and find joy in their latter years.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age and gray hairs I am he, I am he who will sustain you. I have made you and I will carry you; I will sustain you and I will rescue you.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the sick in this region, that You would heal their bodies and restore their health.', 'prayer-global-porch' ),
                'reference' => __( 'James 5:15', 'prayer-global-porch' ),
                'verse' => _x( 'And the prayer offered in faith will make the sick person well; the Lord will raise them up. If they have sinned, they will be forgiven.', 'James 5:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those struggling with suicidal thoughts in this region, that You would bring them hope, peace, and a sense of purpose.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 29:11', 'prayer-global-porch' ),
                'verse' => _x( 'For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future.', 'Jeremiah 29:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for Your healing to touch the sick in this region, restoring their bodies and renewing their strength.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 30:17a', 'prayer-global-porch' ),
                'verse' => _x( 'But I will restore you to health and heal your wounds,’ declares the Lord,', 'Jeremiah 30:17a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your blessing on the hospitals and healthcare workers in this region, that they would bring healing and comfort to the sick and suffering.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 30:17a', 'prayer-global-porch' ),
                'verse' => _x( 'But I will restore you to health and heal your wounds,’ declares the Lord,', 'Jeremiah 30:17a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the elderly in this region, that they would be honored and respected by the younger generations.', 'prayer-global-porch' ),
                'reference' => __( 'Leviticus 19:32', 'prayer-global-porch' ),
                'verse' => _x( '‘Stand up in the presence of the aged, show respect for the elderly and revere your God. I am the Lord.', 'Leviticus 19:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the elderly in this region, that they would be honored and revered in their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Leviticus 19:32', 'prayer-global-porch' ),
                'verse' => _x( '‘Stand up in the presence of the aged, show respect for the elderly and revere your God. I am the Lord.', 'Leviticus 19:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would protect and bless the children in this region, guiding them into a life of faith and hope.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 10:14', 'prayer-global-porch' ),
                'verse' => _x( 'When Jesus saw this, he was indignant. He said to them, ‘Let the little children come to me, and do not hinder them, for the kingdom of God belongs to such as these.’', 'Mark 10:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are unemployed in this region, that they would find work that satisfies and honors You.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 7:7', 'prayer-global-porch' ),
                'verse' => _x( 'Ask and it will be given to you; seek and you will find; knock and the door will be opened to you.', 'Matthew 7:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the unemployed in this region, that You would provide work and open doors for opportunities.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the unemployed in this region, that You would provide meaningful employment for them.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the economically disadvantaged in this region, that You would provide for their needs and help them thrive.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the elderly in this region, that they would be cherished, honored, and live with dignity.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'Gray hair is a crown of splendor; it is attained in the way of righteousness.', 'Proverbs 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the elderly in this region, that they would be treated with dignity and respect, and that they would know the comfort of Your presence.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'Gray hair is a crown of splendor; it is attained in the way of righteousness.', 'Proverbs 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the elderly in this region, that they would be treated with respect and dignity, and that their wisdom would be valued in their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'Gray hair is a crown of splendor; it is attained in the way of righteousness.', 'Proverbs 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the elderly in this region, that they would feel valued and loved by their families and communities.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'Gray hair is a crown of splendor; it is attained in the way of righteousness.', 'Proverbs 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the elderly in this region, that You would surround them with love, care, and support in their later years.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'Gray hair is a crown of splendor; it is attained in the way of righteousness.', 'Proverbs 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the farmers in this region, that You would bless their work and provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 65:9', 'prayer-global-porch' ),
                'verse' => _x( 'You care for the land and water it; you enrich it abundantly. The streams of God are filled with water to provide the people with grain, for so you have ordained it.', 'Psalm 65:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the farmers in this region, that You would bless their work and provide abundant harvests.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 65:9', 'prayer-global-porch' ),
                'verse' => _x( 'You care for the land and water it; you enrich it abundantly. The streams of God are filled with water to provide the people with grain, for so you have ordained it.', 'Psalm 65:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the farmers in this region, that You would bless their crops and provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 65:9', 'prayer-global-porch' ),
                'verse' => _x( 'You care for the land and water it; you enrich it abundantly. The streams of God are filled with water to provide the people with grain, for so you have ordained it.', 'Psalm 65:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, bless the farmers and workers in this region, and may they see the fruit of their labor.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May the workers in this region find fulfillment in their labor, and may they be treated with dignity and respect.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23-24', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters, since you know that you will receive an inheritance from the Lord as a reward. It is the Lord Christ you are serving.', 'Colossians 3:23-24', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_demographic_feature_population_non_christians( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Non-Christians', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Over %1$s percent of the people of %2$s are far from Jesus. Lord, please send your gospel to them through the internet or radio or television today!', 'prayer-global-porch' ), $stack['location']['percent_non_christians'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Over %1$s percent of the people of %2$s are far from Jesus.', 'prayer-global-porch' ), $stack['location']['percent_non_christians'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, call those who are far off in %1$s, so that they and their family can receive life.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Acts 2:39', 'prayer-global-porch' ),
                'verse' => _x( 'For the promise is to you, and to your children, and to all who are far off, even as many as the Lord our God will call to himself.', 'Acts 2:39', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, you said, "The earth belongs to Me and all that is in it". Please, call %1$s into obedience and eternal life.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Psalm 24:1', 'prayer-global-porch' ),
                'verse' => _x( 'The earth is Yahweh’s, with its fullness; the world, and those who dwell therein.', 'Psalm 24:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, let it be said of the %1$s lost in %2$s that you have called them out of darkness into your glorious light.', 'prayer-global-porch' ), $stack['location']['all_lost'], $stack['location']['name'] ),
                'reference' => __( '1 Peter 2:9', 'prayer-global-porch' ),
                'verse' => _x( 'But you are a chosen race, a royal priesthood, a holy nation, a people for God’s own possession, that you may proclaim the excellence of him who called you out of darkness into his marvelous light', '1 Peter 2:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, please make the same Spirit that raised Jesus from the dead give life to those who are called by his name in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Romans 8:11', 'prayer-global-porch' ),
                'verse' => _x( 'But if the Spirit of him who raised up Jesus from the dead dwells in you, he who raised up Christ Jesus from the dead will also give life to your mortal bodies through his Spirit who dwells in you.', 'Romans 8:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, you desire to blot out the sins of the people of %1$s. You said, if they turn to you, you will dissolve their sins like mist.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Isaiah 44:22', 'prayer-global-porch' ),
                'verse' => _x( 'I have blotted out, as a thick cloud, your transgressions, and, as a cloud, your sins. Return to me, for I have redeemed you.', 'Isaiah 44:22', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, please send your Spirit to %1$s, so they can have freedom.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( '2 Corinthians 3:17', 'prayer-global-porch' ),
                'verse' => _x( 'Now the Lord is the Spirit, and where the Spirit of the Lord is, there is freedom.', '2 Corinthians 3:17', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that you open the hearts of people in this region to receive the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 1:16', 'prayer-global-porch' ),
                'verse' => _x( 'For I am not ashamed of the gospel, because it is the power of God that brings salvation to everyone who believes: first to the Jew, then to the Gentile.', 'Romans 1:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the salvation of those who are lost in this country, that they may encounter your love and truth.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 19:10', 'prayer-global-porch' ),
                'verse' => _x( 'For the Son of Man came to seek and to save the lost.', 'Luke 19:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are lost in this region, that they may come to know the saving power of Jesus Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 19:10', 'prayer-global-porch' ),
                'verse' => _x( 'For the Son of Man came to seek and to save the lost.', 'Luke 19:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for a mighty outpouring of the Holy Spirit in this country, that hearts may be opened to the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 2:17', 'prayer-global-porch' ),
                'verse' => _x( '‘In the last days, God says, I will pour out my Spirit on all people. Your sons and daughters will prophesy, your young men will see visions, your old men will dream dreams.', 'Acts 2:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the people of this region, that they would experience your great love and be drawn to you.', 'prayer-global-porch' ),
                'reference' => __( 'John 6:44', 'prayer-global-porch' ),
                'verse' => _x( 'No one can come to me unless the Father who sent me draws them, and I will raise them up at the last day.', 'John 6:44', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the people of this region, that they would seek you and experience your great love.', 'prayer-global-porch' ),
                'reference' => __( '1 John 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'We love because he first loved us.', '1 John 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, please bring revival to this country, transforming hearts and communities for Your glory.', 'prayer-global-porch' ),
                'reference' => __( '2 Chronicles 7:14', 'prayer-global-porch' ),
                'verse' => _x( 'if my people, who are called by my name, will humble themselves and pray and seek my face and turn from their wicked ways, then I will hear from heaven, and I will forgive their sin and will heal their land.', '2 Chronicles 7:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would open the eyes of the people in this region to see Your truth and respond with repentance and faith.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 4:4', 'prayer-global-porch' ),
                'verse' => _x( 'The god of this age has blinded the minds of unbelievers, so that they cannot see the light of the gospel that displays the glory of Christ, who is the image of God.', '2 Corinthians 4:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask that You would open the hearts of the lost in this region to receive the message of salvation and grace.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 4:6', 'prayer-global-porch' ),
                'verse' => _x( 'For God, who said, Let light shine out of darkness,made his light shine in our hearts to give us the light of the knowledge of God’s glory displayed in the face of Christ.', '2 Corinthians 4:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask that Your love would fill the hearts of those in this region, transforming them into passionate disciples of Christ.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 5:14', 'prayer-global-porch' ),
                'verse' => _x( 'For Christ’s love compels us, because we are convinced that one died for all, and therefore all died.', '2 Corinthians 5:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would open the hearts of the people in this region to hear the gospel, that many would come to know You.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 16:14', 'prayer-global-porch' ),
                'verse' => _x( 'One of those listening was a woman from the city of Thyatira, named Lydia, a dealer in purple cloth. She was a worshiper of God. The Lord opened her heart to respond to Paul’s message.', 'Acts 16:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for revival to come to this region, that many would turn to You in repentance and faith.', 'prayer-global-porch' ),
                'reference' => __( 'Habakkuk 3:2', 'prayer-global-porch' ),
                'verse' => _x( 'Lord, I have heard of your fame; I stand in awe of your deeds, Lord. Repeat them in our day, in our time make them known; in wrath remember mercy.', 'Habakkuk 3:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the hearts of the lost in this country to be softened and open to the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Ezekiel 36:26', 'prayer-global-porch' ),
                'verse' => _x( 'I will give you a new heart and put a new spirit in you; I will remove from you your heart of stone and give you a heart of flesh.', 'Ezekiel 36:26', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are seeking You in this region, that they would find You and experience Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 29:13', 'prayer-global-porch' ),
                'verse' => _x( 'You will seek me and find me when you seek me with all your heart.', 'Jeremiah 29:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for a mighty outpouring of the Holy Spirit in this region, that hearts would be convicted of sin and come to a saving knowledge of Jesus Christ.', 'prayer-global-porch' ),
                'reference' => __( 'John 16:8', 'prayer-global-porch' ),
                'verse' => _x( 'When he comes, he will prove the world to be in the wrong about sin and righteousness and judgment:', 'John 16:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask that Your Holy Spirit would move in the hearts of the people in this region, calling them to repentance and faith.', 'prayer-global-porch' ),
                'reference' => __( 'John 16:8', 'prayer-global-porch' ),
                'verse' => _x( 'When he comes, he will prove the world to be in the wrong about sin and righteousness and judgment:', 'John 16:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would reveal Yourself to those who do not yet know You in this region, drawing them to salvation.', 'prayer-global-porch' ),
                'reference' => __( 'John 6:44', 'prayer-global-porch' ),
                'verse' => _x( 'No one can come to me unless the Father who sent me draws them, and I will raise them up at the last day.', 'John 6:44', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the hearts of those in this region who are far from You, that they would come to know Your love and grace.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 19:10', 'prayer-global-porch' ),
                'verse' => _x( 'For the Son of Man came to seek and to save the lost.', 'Luke 19:10', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_demographic_feature_population_christian_adherents( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Cultural Christians', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, %1$s cultural Christians in %2$s likely have a Bible in their home. Please, send conviction for them to open it and read it for themselves.', 'prayer-global-porch' ), $stack['location']['christian_adherents'], $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, teach the %1$s cultural Christians in %2$s to pray from the heart and not with scripts or formulas only.', 'prayer-global-porch' ), $stack['location']['christian_adherents'], $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, bless the %1$s cultural Christians in %2$s with more knowledge and curiosity about your beautiful gospel, that they might claim it for themselves personally and intimately.', 'prayer-global-porch' ), $stack['location']['christian_adherents'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray that the believers in this region would abound in love for one another, just as you have loved us. May they be filled with the knowledge of your will in all wisdom and understanding.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 1:9', 'prayer-global-porch' ),
                'verse' => _x( 'And this is my prayer: that your love may abound more and more in knowledge and depth of insight.', 'Philippians 1:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray that the love of God would abound in this region, drawing many to Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 1:9', 'prayer-global-porch' ),
                'verse' => _x( 'And this is my prayer: that your love may abound more and more in knowledge and depth of insight.', 'Philippians 1:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the elderly in this region, that they would feel your love and experience your peace in their later years.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age and gray hairs I am he, I am he who will sustain you.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that you pour out your wisdom on the youth of this region, guiding them in every area of their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the students in this region, that they would grow in wisdom and knowledge, and seek you above all.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May the church in this country be united in prayer, lifting up the name of Jesus to all.', 'prayer-global-porch' ),
                'reference' => __( '2 Chronicles 7:14', 'prayer-global-porch' ),
                'verse' => _x( 'If my people, who are called by my name, will humble themselves and pray and seek my face and turn from their wicked ways, then I will hear from heaven, and I will forgive their sin and will heal their land.', '2 Chronicles 7:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that you would bring unity to the churches in this country, that they may work together to further your Kingdom.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for unity among the churches in this region, that they would work together to spread the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for the churches in this region to be united in their mission to spread the gospel with one heart and mind.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for unity among the Christians in this region, that they may be one in spirit and purpose.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the women in this region, that they may be empowered, valued, and used mightily in your kingdom.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:15', 'prayer-global-porch' ),
                'verse' => _x( 'She is more precious than rubies; nothing you desire can compare with her.', 'Proverbs 3:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the students in this region, that they may grow in wisdom and knowledge, and also in a love for God.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of knowledge, but fools despise wisdom and instruction.', 'Proverbs 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the marriages in this region, that they would be strengthened by your love and grace.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 10:9', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore what God has joined together, let no one separate.', 'Mark 10:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray that marriages in this region would be strengthened by your love and grace, reflecting your covenant faithfulness.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 10:9', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore what God has joined together, let no one separate.', 'Mark 10:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would pour out Your Spirit on the churches in this region, empowering them to reach out with compassion and grace.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'You will receive power when the Holy Spirit comes on you.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for marriages in this region, that they would be built on love, trust, and mutual respect.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 13:4-7', 'prayer-global-porch' ),
                'verse' => _x( 'Love is patient, love is kind. It does not envy, it does not boast, it is not proud. It does not dishonor others, it is not self-seeking, it is not easily angered, it keeps no record of wrongs. Love does not delight in evil but rejoices with the truth. It always protects, always trusts, always hopes, always perseveres.', '1 Corinthians 13:4-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the youth who are influenced by negative peer pressure in this region, that they would have the strength to make wise decisions.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 15:33', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be misled: ‘Bad company corrupts good character.’', '1 Corinthians 15:33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the youth in this region, that they would be strong in character and resist the temptations of the world.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 16:13', 'prayer-global-porch' ),
                'verse' => _x( 'Be on your guard; stand firm in the faith; be courageous; be strong.', '1 Corinthians 16:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the young adults in this region, that they would seek Your will for their lives and be strong in faith.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for Your favor upon the youth in this region, that they would rise up to be mighty witnesses of Your love and grace.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the youth in this region, that they would grow in knowledge and reverence for You.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the youth in this region, that they would grow in wisdom and strength, pursuing You with their whole hearts.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your Spirit to move powerfully in this region, bringing conviction and revival to every heart.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses in Jerusalem, and in all Judea and Samaria, and to the ends of the earth.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your Spirit to move in this region, bringing revival to every home and community.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 2:17', 'prayer-global-porch' ),
                'verse' => _x( 'In the last days, God says, I will pour out my Spirit on all people. Your sons and daughters will prophesy, your young men will see visions, your old men will dream dreams.', 'Acts 2:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for a fresh outpouring of Your Spirit upon the churches in this region, empowering them to be agents of transformation in their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 2:4', 'prayer-global-porch' ),
                'verse' => _x( 'All of them were filled with the Holy Spirit and began to speak in other tongues as the Spirit enabled them.', 'Acts 2:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the children in this region. May they grow in knowledge, wisdom, and favor with You and with people.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 2:52', 'prayer-global-porch' ),
                'verse' => _x( 'And Jesus grew in wisdom and stature, and in favor with God and man.', 'Luke 2:52', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the families in this region. May they grow together in love, trust, and faith in You.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for families in this region, that they would be rooted in Your love and grow together in Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for families in this region, asking for Your protection, unity, and love to reign in their homes.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the families in this region, that they would grow in love for one another and seek to honor You in all their relationships.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:13', 'prayer-global-porch' ),
                'verse' => _x( 'Bear with each other and forgive one another if any of you has a grievance against someone. Forgive as the Lord forgave you.', 'Colossians 3:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for families in this region, that they would grow stronger together in love, faith, and unity.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:14', 'prayer-global-porch' ),
                'verse' => _x( 'And over all these virtues put on love, which binds them all together in perfect unity.', 'Colossians 3:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the youth in this region who are seeking purpose and identity, that they would find it in You alone.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 1  3:3', 'prayer-global-porch' ),
                'verse' => _x( 'For you died, and your life is now hidden with Christ in God.', 'Colossians 1  3:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for Your guidance for the parents in this region, that they would know how to raise their children in Your ways.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'These commandments that I give you today are to be on your hearts. Impress them on your children. Talk about them when you sit at home and when you walk along the road, when you lie down and when you get up.', 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the children in this region, that they would grow up knowing You and become strong witnesses of Your love and truth.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'These commandments that I give you today are to be on your hearts. Impress them on your children. Talk about them when you sit at home and when you walk along the road, when you lie down and when you get up.', 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the parents in this region, that they would be strong in their faith and lead their children with wisdom and love.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'These commandments that I give you today are to be on your hearts. Impress them on your children. Talk about them when you sit at home and when you walk along the road, when you lie down and when you get up.', 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the parents in this region, that they would have wisdom in raising their children and nurturing them in faith.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'These commandments that I give you today are to be on your hearts. Impress them on your children. Talk about them when you sit at home and when you walk along the road, when you lie down and when you get up.', 'Deuteronomy 6:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for families in this region, that You would protect them and strengthen their bonds in Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 3:17', 'prayer-global-porch' ),
                'verse' => _x( 'So that Christ may dwell in your hearts through faith. And I pray that you, being rooted and established in love…', 'Ephesians 3:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the church in this region to grow in faith, unity, and love, reflecting Your kingdom to the world.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:15-16', 'prayer-global-porch' ),
                'verse' => _x( 'Instead, speaking the truth in love, we will grow to become in every respect the mature body of him who is the head, that is, Christ. From him the whole body, joined and held together by every supporting ligament, grows and builds itself up in love, as each part does its work.', 'Ephesians 4:15-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the families in this region, that they would grow in unity, love, and respect for one another.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:2', 'prayer-global-porch' ),
                'verse' => _x( 'Be completely humble and gentle; be patient, bearing with one another in love.', 'Ephesians 4:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for families in this region, that they would be filled with Your love and grow in unity, reflecting Your goodness to the world.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:2', 'prayer-global-porch' ),
                'verse' => _x( 'Be completely humble and gentle; be patient, bearing with one another in love.', 'Ephesians 4:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are struggling with unforgiveness in this region, that they would experience Your grace and extend forgiveness to others.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:32', 'prayer-global-porch' ),
                'verse' => _x( 'Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.', 'Ephesians 4:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those struggling with unforgiveness in this region, that You would soften their hearts and help them to forgive others as You have forgiven them.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:32', 'prayer-global-porch' ),
                'verse' => _x( 'Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.', 'Ephesians 4:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for marriages in this region, that husbands and wives would love each other sacrificially and reflect the love of Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for marriages in this region, that You would strengthen the bonds between husbands and wives.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:33', 'prayer-global-porch' ),
                'verse' => _x( 'However, each one of you also must love his wife as he loves himself, and the wife must respect her husband.', 'Ephesians 5:33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the parents in this region, that they would raise their children in the nurture and admonition of the Lord.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 6:4', 'prayer-global-porch' ),
                'verse' => _x( 'Fathers, do not exasperate your children; instead, bring them up in the training and instruction of the Lord.', 'Ephesians 6:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, help the believers in this country to be generous and to share their resources with those in need.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 6:38', 'prayer-global-porch' ),
                'verse' => _x( 'Give, and it will be given to you. A good measure, pressed down, shaken together and running over, will be poured into your lap. For with the measure you use, it will be measured to you.', 'Luke 6:38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for a move of Your Spirit in this region, stirring up revival in the hearts of Your people.', 'prayer-global-porch' ),
                'reference' => __( 'Habakkuk 3:2', 'prayer-global-porch' ),
                'verse' => _x( 'Lord, I have heard of your fame; I stand in awe of your deeds, Lord. Repeat them in our day, in our time make them known; in wrath remember mercy.', 'Habakkuk 3:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for a powerful move of Your Spirit in this region. Stir hearts, awaken faith, and bring revival that transforms every home and community.', 'prayer-global-porch' ),
                'reference' => __( 'Habakkuk 3:2', 'prayer-global-porch' ),
                'verse' => _x( 'Lord, I have heard of your fame; I stand in awe of your deeds, Lord. Repeat them in our day, in our time make them known; in wrath remember mercy.', 'Habakkuk 3:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, help the believers in this region to live in unity and harmony, showing the world the love of Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 133:1', 'prayer-global-porch' ),
                'verse' => _x( 'How good and pleasant it is when God’s people live together in unity!', 'Psalm 133:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, empower believers in this country to share Your love through acts of kindness.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:16', 'prayer-global-porch' ),
                'verse' => _x( 'In the same way, let your light shine before others, that they may see your good deeds and glorify your Father in heaven.', 'Matthew 5:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, bless the churches in this region, that they would rise up as voices of truth and hope to a hurting world.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:16', 'prayer-global-porch' ),
                'verse' => _x( 'In the same way, let your light shine before others, that they may see your good deeds and glorify your Father in heaven.', 'Matthew 5:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the elderly in this region, that they would be honored, respected, and experience Your love in their later years.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age and gray hairs I am he, I am he who will sustain you. I have made you and I will carry you; I will sustain you and I will rescue you.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the elderly in this region, that You would protect them and fill their hearts with joy and purpose in their later years.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age and gray hairs I am he, I am he who will sustain you. I have made you and I will carry you; I will sustain you and I will rescue you.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the elderly in this region, that they would experience Your peace and joy, knowing their value in Your eyes.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age and gray hairs I am he, I am he who will sustain you. I have made you and I will carry you; I will sustain you and I will rescue you.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the elderly in this region, that they would experience Your peace and joy, knowing their value in Your kingdom.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age and gray hairs I am he, I am he who will sustain you. I have made you and I will carry you; I will sustain you and I will rescue you.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the elderly in this region, that they would find strength in You and be surrounded by the love of family and community.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age and gray hairs I am he, I am he who will sustain you. I have made you and I will carry you; I will sustain you and I will rescue you.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the youth in this region, that they would grow up knowing their worth in Christ and living lives of purpose.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 29:11', 'prayer-global-porch' ),
                'verse' => _x( 'For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future.', 'Jeremiah 29:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, raise up a generation in this country that seeks to live out Your Word daily.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'Keep this Book of the Law always on your lips; meditate on it day and night, so that you may be careful to do everything written in it. Then you will be prosperous and successful.', 'Joshua 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the families in this region to be strong in faith, unity, and love, reflecting Your grace and mercy.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15b', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15b', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the families in this region, that You would strengthen their relationships and help them to build their homes on the foundation of Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15b', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15b', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the children in this region, that they would grow in wisdom and stature, and in favor with God and man.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 2:52', 'prayer-global-porch' ),
                'verse' => _x( 'And Jesus grew in wisdom and stature, and in favor with God and man.', 'Luke 2:52', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the elderly in this region, that they would be valued, respected, and cared for in their later years.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'Gray hair is a crown of splendor; it is attained in the way of righteousness.', 'Proverbs 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the youth who have drifted away from the church in this region, that You would draw them back to You and restore their faith.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_demographic_feature_population_believers( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Believer Families', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, thank you for the %1$s whom you have brought close through the blood of Christ already in %2$s.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'] ),
                'reference' => __( 'Ephesians 2:13', 'prayer-global-porch' ),
                'verse' => _x( 'But now in Christ Jesus you who once were far off are made near in the blood of Christ.', 'Ephesians 2:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, thank you for the %1$s people that you have made believe and given eternal life to in %2$s.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'] ),
                'reference' => __( 'John 3:16', 'prayer-global-porch' ),
                'verse' => _x( 'For God so loved the world, that he gave his only Son, that whoever believes in him should not perish but have eternal life.', 'John 3:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, you made each of the %1$s believers in %2$s your ambassadors and your primary strategy for reconciling this %3$s .', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'], $stack['location']['admin_level_title'] ),
                'reference' => __( '2 Corinthians 5:20', 'prayer-global-porch' ),
                'verse' => _x( 'We are therefore Christ’s ambassadors, as though God were making his appeal through us. We implore you on Christ’s behalf: Be reconciled to God.', '2 Corinthians 5:20', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that you would strengthen the faith of believers in this region, that they would remain firm in their commitment to you.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 16:13', 'prayer-global-porch' ),
                'verse' => _x( 'Be on your guard; stand firm in the faith; be courageous; be strong.', '1 Corinthians 16:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May every believer in this country feel your peace and courage to stand firm in their faith.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 31:6', 'prayer-global-porch' ),
                'verse' => _x( 'Be strong and courageous. Do not be afraid or terrified because of them, for the Lord your God goes with you; he will never leave you nor forsake you.', 'Deuteronomy 31:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the love of Christ be evident in every believer\'s life in this country.', 'prayer-global-porch' ),
                'reference' => __( 'John 13:35', 'prayer-global-porch' ),
                'verse' => _x( 'By this everyone will know that you are my disciples, if you love one another.', 'John 13:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may your love and grace overflow in the lives of the believers in this country, reaching the lost.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 5:14', 'prayer-global-porch' ),
                'verse' => _x( 'For Christ’s love compels us, because we are convinced that one died for all, and therefore all died.', '2 Corinthians 5:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for unity in the body of Christ in this region, that together we may work for the good of the community and for your glory.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 133:1', 'prayer-global-porch' ),
                'verse' => _x( 'How good and pleasant it is when God’s people live together in unity!', 'Psalm 133:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the communities in this region, that they would experience your peace and unity despite divisions.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 133:1', 'prayer-global-porch' ),
                'verse' => _x( 'How good and pleasant it is when God’s people live together in unity!', 'Psalm 133:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, strengthen those who are struggling in their faith, that they may persevere.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:13', 'prayer-global-porch' ),
                'verse' => _x( 'I can do all this through him who gives me strength.', 'Philippians 4:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may your love flood the hearts of every believer in this country and overflow to those around them.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 16:14', 'prayer-global-porch' ),
                'verse' => _x( 'Let all that you do be done in love.', '1 Corinthians 16:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'For the isolated believers in this region, we ask that you would bring them into fellowship with others who love you.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 10:25', 'prayer-global-porch' ),
                'verse' => _x( 'not giving up meeting together, as some are in the habit of doing, but encouraging one another—and all the more as you see the Day approaching.', 'Hebrews 10:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are isolated in their faith, that you would bring them community.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 10:25', 'prayer-global-porch' ),
                'verse' => _x( 'not giving up meeting together, as some are in the habit of doing, but encouraging one another—and all the more as you see the Day approaching.', 'Hebrews 10:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for unity within the body of Christ in this country, that the world may know you.', 'prayer-global-porch' ),
                'reference' => __( 'John 17:21', 'prayer-global-porch' ),
                'verse' => _x( 'That all of them may be one, Father, just as you are in me and I am in you.', 'John 17:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, may your joy be evident in the lives of the believers in this region, even amid challenges and hardships.', 'prayer-global-porch' ),
                'reference' => __( 'Nehemiah 8:10b', 'prayer-global-porch' ),
                'verse' => _x( 'The joy of the Lord is your strength.', 'Nehemiah 8:10b', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may every believer in this country experience the fullness of your joy.', 'prayer-global-porch' ),
                'reference' => __( 'Nehemiah 8:10b', 'prayer-global-porch' ),
                'verse' => _x( 'The joy of the Lord is your strength.', 'Nehemiah 8:10b', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the people of this region experience the joy of knowing you and living according to your Word.', 'prayer-global-porch' ),
                'reference' => __( 'Nehemiah 8:10b', 'prayer-global-porch' ),
                'verse' => _x( 'The joy of the Lord is your strength.', 'Nehemiah 8:10b', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for every worker in this region: may they labor wholeheartedly, as serving You and not merely people. Fill them with purpose and joy in every task, and let their efforts bring honor to Your name.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord God, we pray for the unemployed in this region, asking You to open doors for them and provide meaningful work that enables them to serve You and others.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the unity of the Body of Christ in this region, that we may work together to fulfill Your Great Commission.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 1:10', 'prayer-global-porch' ),
                'verse' => _x( 'I appeal to you, brothers and sisters, in the name of our Lord Jesus Christ, that all of you agree with one another in what you say and that there be no divisions among you, but that you be perfectly united in mind and thought.', '1 Corinthians 1:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for unity in the church in this region, that all believers would come together in one spirit to fulfill Your mission.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 1:10', 'prayer-global-porch' ),
                'verse' => _x( 'I appeal to you, brothers and sisters, in the name of our Lord Jesus Christ, that all of you agree with one another in what you say and that there be no divisions among you, but that you be perfectly united in mind and thought.', '1 Corinthians 1:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the unity of the Body of Christ in this region, that all believers may work together in harmony for Your glory.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 1:10', 'prayer-global-porch' ),
                'verse' => _x( 'I appeal to you, brothers and sisters, in the name of our Lord Jesus Christ, that all of you agree with one another in what you say and that there be no divisions among you, but that you be perfectly united in mind and thought.', '1 Corinthians 1:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the youth in this region, that they would be a generation filled with faith and purpose, serving You with passion.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the youth in this region, that they would remain strong in faith and be filled with the Spirit of wisdom and understanding.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that Your peace would reign in this region, where there is division and unrest. May Your Church be a beacon of reconciliation.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:9', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are the peacemakers, for they will be called children of God.', 'Matthew 5:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for peace to reign in this region, and that Your Church would be an instrument of peace in their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:9', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are the peacemakers, for they will be called children of God.', 'Matthew 5:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for peace in the homes of this region, that families would be strong in love and faith.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray that Your peace would reign in the hearts of all believers in this region, uniting them in love and purpose.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:15', 'prayer-global-porch' ),
                'verse' => _x( 'Let the peace of Christ rule in your hearts, since as members of one body you were called to peace. And be thankful.', 'Colossians 3:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the young adults in this region, that they would find their identity in You and live lives that honor You.', 'prayer-global-porch' ),
                'reference' => __( 'Ecclesiastes 12:1', 'prayer-global-porch' ),
                'verse' => _x( 'Remember your Creator in the days of your youth, before the days of trouble come.', 'Ecclesiastes 12:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for Your spirit of peace to cover the families in this region, that they would experience unity and love in Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for families in this region, that they would experience unity, love, and Your peace.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the marriages in this region, that husbands and wives would love each other sacrificially and reflect Your love to the world.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the married couples in this region, that they would grow in mutual respect, love, and faithfulness.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:33', 'prayer-global-porch' ),
                'verse' => _x( 'However, each one of you also must love his wife as he loves himself, and the wife must respect her husband.', 'Ephesians 5:33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for a spirit of unity among the believers in this region, that they would be one as You and the Father are one.', 'prayer-global-porch' ),
                'reference' => __( 'John 17:21', 'prayer-global-porch' ),
                'verse' => _x( 'that all of them may be one, Father, just as you are in me and I am in you. May they also be in us so that the world may believe that you have sent me.', 'John 17:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would bring unity to the believers in this region, that they would be one in Christ and work together for Your glory.', 'prayer-global-porch' ),
                'reference' => __( 'John 17:21', 'prayer-global-porch' ),
                'verse' => _x( 'that all of them may be one, Father, just as you are in me and I am in you. May they also be in us so that the world may believe that you have sent me.', 'John 17:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your protection over the children in this region, that they may grow in wisdom and stature before You.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 2:52', 'prayer-global-porch' ),
                'verse' => _x( 'And Jesus grew in wisdom and stature, and in favor with God and man.', 'Luke 2:52', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the churches in this region to be places of refuge, healing, and grace for all who come.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 11:28', 'prayer-global-porch' ),
                'verse' => _x( 'Come to me, all you who are weary and burdened, and I will give you rest.', 'Matthew 11:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the churches in this region to be places of refuge and hope, where people find healing and community.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 11:28', 'prayer-global-porch' ),
                'verse' => _x( 'Come to me, all you who are weary and burdened, and I will give you rest.', 'Matthew 11:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for Your presence to dwell richly in the churches of this region, that they may be vibrant centers of worship, prayer, and discipleship.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 18:20', 'prayer-global-porch' ),
                'verse' => _x( 'For where two or three gather in my name, there am I with them.', 'Matthew 18:20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray that Your peace would reign in the hearts of the believers in this region, guarding them in times of trial.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the media in this region, that it would be used to promote truth, love, and justice for all people.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:8', 'prayer-global-porch' ),
                'verse' => _x( 'Finally, brothers and sisters, whatever is true, whatever is noble, whatever is right, whatever is pure, whatever is lovely, whatever is admirable—if anything is excellent or praiseworthy—think about such things.', 'Philippians 4:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the students in this region, that they would excel in their studies and be equipped for the future You have for them.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'let the wise listen and add to their learning, and let the discerning get guidance', 'Proverbs 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the students in this region, that they would grow in both knowledge and character, reflecting Christ in their schools.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of knowledge, but fools despise wisdom and instruction. Proverbs 1:7', 'Proverbs 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the students in this region, that they would grow in knowledge, wisdom, and grace, seeking You in all their learning.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of knowledge, but fools despise wisdom and instruction. Proverbs 1:7', 'Proverbs 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the students in this region, that they would pursue knowledge and wisdom that honors You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of knowledge, but fools despise wisdom and instruction. Proverbs 1:7', 'Proverbs 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the students in this region, that they would be diligent in their studies and have discernment in their decisions.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would bless the students in this region with wisdom and understanding, and that they would seek knowledge with a heart for You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the students in this region, that they would excel in their studies and use their education to honor You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the students in this region, that they would grow in knowledge and wisdom, and be a light to those around them.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the children in this region, that they would grow up in the knowledge of You and be a light to their generation.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we lift up the young mothers in this region. Strengthen and empower them to nurture their children in the knowledge and reverence of You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the children in this region, that they would come to know You early and live lives of faith.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the leaders of businesses in this region, that they would use their influence for the good of the people and the glory of Your name.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:9', 'prayer-global-porch' ),
                'verse' => _x( 'Honor the Lord with your wealth, with the firstfruits of all your crops;', 'Proverbs 3:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for wisdom for the leaders in this region, that they would govern justly, seeking the good of all people and promoting peace.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 8:15-16', 'prayer-global-porch' ),
                'verse' => _x( 'By me kings reign and rulers issue decrees that are just; by me princes govern, and nobles—all who rule on earth.', 'Proverbs 8:15-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those struggling with feelings of inadequacy in this region, that they would find their worth and identity in You.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 139:14', 'prayer-global-porch' ),
                'verse' => _x( 'I praise you because I am fearfully and wonderfully made; your works are wonderful, I know that full well.', 'Psalm 139:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the single parents in this region, that You would give them strength, patience, and joy as they raise their children.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the single parents in this region, that You would provide them with strength, support, and guidance as they raise their children.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( '2 Chronicles 16:9a', 'prayer-global-porch' ),
//                'verse' => _x( 'For the eyes of the LORD range throughout the earth to strengthen those whose hearts are fully committed to him.', '2 Chronicles 16:9a', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( '1 Chronicles 16:11', 'prayer-global-porch' ),
//                'verse' => _x( 'Seek the LORD and His strength; Seek His face continually.', '1 Chronicles 16:11', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( 'Psalm 105:3-4', 'prayer-global-porch' ),
//                'verse' => _x( 'Glory in his holy name; let the hearts of those who seek the Lord rejoice. Look to the Lord and his strength; seek his face always.', 'Psalm 105:3-4', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( '1 Chronicles 16:10b-11', 'prayer-global-porch' ),
//                'verse' => _x( 'Let the heart of those who seek the Lord be glad. Seek the Lord and his strength; seek his presence continually.', '1 Chronicles 16:10b-11', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( 'Psalm 34:5', 'prayer-global-porch' ),
//                'verse' => _x( 'Those who look to him are radiant; their faces are never covered with shame.', 'Psalm 34:5', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( '2 Timothy 2:15', 'prayer-global-porch' ),
//                'verse' => _x( 'Do your best to present yourself to God as one approved, a worker who does not need to be ashamed and who correctly handles the word of truth.', '2 Timothy 2:15', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_demographic_feature_primary_religion( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) { // @todo the primary religion is too general for the specific states and counties
        if ( 'Christianity' === $stack['location']['primary_religion'] ) {
            return $lists;
        }

        $section_label = __( 'Primary Religion', 'prayer-global-porch' );
        $current_templates = [
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'The primary religion in %1$s of %2$s is %3$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'], $stack['location']['primary_religion'] ),
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'Father, give the %1$s believers in %2$s of %3$s the skill to communicate your gospel to those who follow %4$s around them.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['admin_level_title'], $stack['location']['name'], $stack['location']['primary_religion'] ),
//                'reference' => __( 'Ephesians 6:19', 'prayer-global-porch' ),
//                'verse' => _x( 'Pray also for me, that whenever I speak, words may be given me so that I will fearlessly make known the mystery of the gospel,', 'Ephesians 6:19', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'Father, many people in %1$s follow %2$s. Please give them accurate knowledge of Jesus.', 'prayer-global-porch' ), $stack['location']['full_name'], $stack['location']['primary_religion'] ),
//                'reference' => __( 'Romans 10:2', 'prayer-global-porch' ),
//                'verse' => _x( 'For I can testify about them that they are zealous for God, but their zeal is not based on knowledge.', 'Romans 10:2', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'Lord, increase spiritual dissatisfaction among those in %1$s of %2$s who follow %3$s', so that they would begin to seek you.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'], $stack['location']['primary_religion'] ),
//                'reference' => __( 'Romans 10:2', 'prayer-global-porch' ),
//                'verse' => _x( 'For I can testify about them that they are zealous for God, but their zeal is not based on knowledge.', 'Romans 10:2', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'Even though the primary religion is %1$s' in %2$s, Lord, call to yourself persons of peace among the community...those who fear you with the best knowledge they have.', 'prayer-global-porch' ), $stack['location']['primary_religion'] , $stack['location']['name'] ),
//                'reference' => __( 'Acts 10:1-2', 'prayer-global-porch' ),
//                'verse' => _x( 'At Caesarea there was a man named Cornelius, a centurion in what was known as the Italian Regiment. He and all his family were devout and God-fearing; he gave generously to those in need and prayed to God regularly.', 'Acts 10:1-2', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
        ];

        $ai_templates = [];
        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_demographic_feature_primary_language( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) { // @todo the primary religion is too general for the specific states and counties
        if ( 'English' === $stack['location']['primary_language'] ) {
            return $lists;
        }

        $section_label = __( 'Language', 'prayer-global-porch' );
        $current_templates = [
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'Father, please provide access to your written Word in the %1$s language.', 'prayer-global-porch' ), $stack['location']['primary_language'] ),
//                'reference' => __( 'Isaiah 55:11', 'prayer-global-porch' ),
//                'verse' => _x( 'So will My word be which goes forth from My mouth; It will not return to Me empty, Without accomplishing what I desire, And without succeeding in the matter for which I sent it.', 'Isaiah 55:11', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'Father, please send those who can create videos and podcasts for the %1$s language for the %2$s of %3$s.', 'prayer-global-porch' ), $stack['location']['primary_language'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'Father, please provide digital and printed Bibles in %1$s of %2$s specifically in the %3$s language. Give success to those who distribute them.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'], $stack['location']['primary_language'] ),
//                'reference' => __( 'Isaiah 55:11', 'prayer-global-porch' ),
//                'verse' => _x( 'So will My word be which goes forth from My mouth; It will not return to Me empty, Without accomplishing what I desire, And without succeeding in the matter for which I sent it.', 'Isaiah 55:11', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'Father, please provide a translation of the Bible in the %1$s language to every seeker in %2$s of %3$s.', 'prayer-global-porch' ), $stack['location']['primary_language'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'Spirit, please, send the truth about Jesus through youTube, Tiktok, and Instagram in the %1$s language for the %2$s of %3$s.', 'prayer-global-porch' ), $stack['location']['primary_language'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => sprintf( __( 'Lord, raise up workers in the %1$s language, who can communicate accurately the Word of truth.', 'prayer-global-porch' ), $stack['location']['primary_language'] ),
//                'reference' => __( '2 Timothy 2:15', 'prayer-global-porch' ),
//                'verse' => _x( 'a worker who does not need to be ashamed and who correctly handles the word of truth.', '2 Timothy 2:15', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
        ];

        $ai_templates = [];
        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_people_groups_by_least_reached_status( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Prayer Movement', 'prayer-global-porch' );
        $current_templates = [];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the gospel of peace go forth to the farthest reaches of this country, reaching the unreached.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 10:15b', 'prayer-global-porch' ),
                'verse' => _x( 'How beautiful are the feet of those who bring good news!', 'Romans 10:15b', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, let your light shine through the believers in this country, breaking through darkness.', 'prayer-global-porch' ),
                'reference' => __( 'John 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'The light shines in the darkness, and the darkness has not overcome it.', 'John 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are lost in darkness in this region. May the light of Christ shine brightly in their lives, leading them to salvation.', 'prayer-global-porch' ),
                'reference' => __( 'John 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'The light shines in the darkness, and the darkness has not overcome it.', 'John 1:5', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_people_groups_by_reached_status( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Prayer Movement', 'prayer-global-porch' );
        $current_templates = [];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray that Your Spirit would fill the believers in this region with power to boldly proclaim Your truth.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses in Jerusalem, and in all Judea and Samaria, and to the ends of the earth.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_people_groups_by_religion( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Prayer Movement', 'prayer-global-porch' );
        $current_templates = [];
        $ai_templates = [];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_people_groups_by_population( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'People Groups', 'prayer-global-porch' );
        $current_templates = [
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
        ];

        $ai_templates = [];
        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_local_leadership( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) { // local leadership and lay leadership
        $section_label = __( 'Local Leadership', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, build the strength and maturity of the local leaders in %1$s. Show them that faithfulness is better than knowledge. Show them that the Spirit, the Word, and prayer is enough in order to grow and lead.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'God, we ask you to raise up elders and deacons from the %1$s believers in %2$s, who will serve the church and equip it to do your work.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => __( 'Ephesians 4:11-13', 'prayer-global-porch' ),
                'verse' => _x( 'So Christ himself gave the apostles, the prophets, the evangelists, the pastors and teachers, to equip his people for works of service, so that the body of Christ may be built up until we all reach unity in the faith and in the knowledge of the Son of God and become mature, attaining to the whole measure of the fullness of Christ.', 'Ephesians 4:11-13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => __( 'Movement Leadership', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Father, we pray for every movement leader and disciple in %1$s of %2$s that they would have deepening intimacy with you.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'John 14:20', 'prayer-global-porch' ),
                'verse' => _x( 'On that day you will realize that I am in my Father, and you are in me, and I am in you.', 'John 14:20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, grace the churches in %1$s with faithful local leaders.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Proverbs 11:14', 'prayer-global-porch' ),
                'verse' => _x( 'Where there is no guidance, a people falls, but in an abundance of counselors there is safety.', 'Proverbs 11:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, teach the local leaders in %1$s to be humble and to serve others.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 20:26–28', 'prayer-global-porch' ),
                'verse' => _x( 'It shall not be so among you. But whoever would be great among you must be your servant, and whoever would be first among you must be your slave, even as the Son of Man came not to be served but to serve, and to give his life as a ransom for many.', 'Matthew 20:26–28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, help the local leaders in %1$s to be faithful with what they have been given, whether a little or a lot.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Luke 12:48b', 'prayer-global-porch' ),
                'verse' => _x( 'Everyone to whom much was given, of him much will be required, and from him to whom they entrusted much, they will demand the more.', 'Luke 12:48b', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, help the local leaders in %1$s not be proud but humble, and willing to wash the feet of all they serve.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'John 13:13–15', 'prayer-global-porch' ),
                'verse' => _x( '“You call me ‘Teacher’ and ‘Lord,’ and rightly so, for that is what I am. Now that I, your Lord and Teacher, have washed your feet, you also should wash one another’s feet. I have set you an example that you should do as I have done for you.', 'John 13:13–15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, may the churches in %1$s honor local leaders who work hard for the flock of God.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Acts 20:28', 'prayer-global-porch' ),
                'verse' => _x( 'Pay careful attention to yourselves and to all the flock, in which the Holy Spirit has made you overseers, to care for the church of God, which he obtained with his own blood.', 'Acts 20:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, knowing that teachers will be judged more strictly, help the local leaders in %1$s to be careful with their words.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'James 3:1', 'prayer-global-porch' ),
                'verse' => _x( 'Not many of you should become teachers, my brothers, for you know that we who teach will be judged with greater strictness.', 'James 3:1', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that you raise up strong leaders in this region, men and women who are filled with your Spirit and wisdom.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 1:9', 'prayer-global-porch' ),
                'verse' => _x( 'Have I not commanded you? Be strong and courageous. Do not be afraid; do not be discouraged, for the Lord your God will be with you wherever you go.', 'Joshua 1:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the church leaders in this region, that they would be filled with your wisdom and grace as they lead your people.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the leaders of this country, that they may have wisdom and compassion in their leadership.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We ask for your guidance in the lives of ministry leaders in this region, that they may walk in wisdom and grace.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for your Spirit to give wisdom and discernment to those leading the church in this country.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the leaders in this region, that they may seek wisdom from you in every decision they make.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those in leadership in this region, that they would make decisions based on justice, compassion, and your wisdom.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for youth leaders in this region, that they would inspire young people to grow in their faith and live boldly for you.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we lift up the workers in this region. May they find joy in their labor and be honored with dignity and respect in all they do.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:24', 'prayer-global-porch' ),
                'verse' => _x( 'Since you know that you will receive an inheritance from the Lord as a reward, it is the Lord Christ you are serving.', 'Colossians 3:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the leaders of the educational institutions in this region, that they would impart knowledge and wisdom rooted in truth.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 9:10', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of wisdom, and knowledge of the Holy One is understanding.', 'Proverbs 9:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the church leaders in this region, that they may lead with humility, wisdom, and a deep love for the people they serve.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 5:2-3', 'prayer-global-porch' ),
                'verse' => _x( 'Be shepherds of God’s flock that is under your care, watching over them—not because you must, but because you are willing, as God wants you to be; not pursuing dishonest gain, but eager to serve; not lording it over those entrusted to you, but being examples to the flock.', '1 Peter 5:2-3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the youth pastors in this region, that You would empower them to disciple the next generation to live boldly for Christ.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the people in this region who are facing unemployment, that You would provide for their needs and open doors for new opportunities.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 9:8', 'prayer-global-porch' ),
                'verse' => _x( 'And God is able to bless you abundantly, so that in all things at all times, having all that you need, you will abound in every good work.', '2 Corinthians 9:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask that You would bless the families of missionaries in this region, providing them with all they need for strength and endurance.', 'prayer-global-porch' ),
                'reference' => __( '2 Thessalonians 3:3', 'prayer-global-porch' ),
                'verse' => _x( 'But the Lord is faithful, and he will strengthen you and protect you from the evil one.', '2 Thessalonians 3:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the men in this region, that they would take up their role as leaders in their homes, communities, and workplaces.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Raise up the men in this region to be leaders in their homes, communities, and workplaces, rooted in Your Word.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those in this region working in the arts and entertainment, that they would use their talents to glorify You and uplift others.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:17', 'prayer-global-porch' ),
                'verse' => _x( 'And whatever you do, whether in word or deed, do it all in the name of the Lord Jesus, giving thanks to God the Father through him.', 'Colossians 3:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the people working in the medical field in this region, that You would give them wisdom, skill, and compassion in their work.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those working in the arts in this region, that they would use their talents to glorify You and inspire others.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the workers in this region, that they would work with integrity and be treated with respect and dignity.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the workers in this region, that You would provide them with the strength and resources to continue their labor with purpose.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the laborers in this region, that they would work with integrity and dedication, honoring You in all they do.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the workers in this region, that they would have the strength and courage to continue in their work, glorifying You in all they do.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the workers in this region, that You would bless them with fulfilling work and a sense of purpose in all they do.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:23', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever you do, work at it with all your heart, as working for the Lord, not for human masters,', 'Colossians 3:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your favor to rest upon the businesses in this region, that they may prosper and serve the community.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 28:12', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will open the heavens, the storehouse of his bounty, to send rain on your land in season and to bless all the work of your hands. You will lend to many nations but will borrow from none.', 'Deuteronomy 28:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the parents of children with special needs in this region, that You would give them patience, strength, and wisdom.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 41:10', 'prayer-global-porch' ),
                'verse' => _x( 'So do not fear, for I am with you; do not be dismayed, for I am your God. I will strengthen you and help you; I will uphold you with my righteous right hand.', 'Isaiah 41:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask for Your peace to fill the hearts of the leaders in this region, guiding them to make wise and just decisions.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 9:6', 'prayer-global-porch' ),
                'verse' => _x( 'For to us a child is born, to us a son is given, and the government will be on his shoulders. And he will be called Wonderful Counselor, Mighty God, Everlasting Father, Prince of Peace.', 'Isaiah 9:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would give wisdom to the educators in this region, that they may teach with grace and knowledge.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the teachers and leaders in the churches in this region, that they would have wisdom and discernment to lead with integrity and faith.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for Your wisdom to guide the leaders of this region, that they would lead with integrity and make decisions that honor You.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the leaders of the churches in this region, that they would lead with humility, integrity, and the wisdom that comes from You.', 'prayer-global-porch' ),
                'reference' => __( 'James 3:17', 'prayer-global-porch' ),
                'verse' => _x( 'But the wisdom that comes from heaven is first of all pure; then peace-loving, considerate, submissive, full of mercy and good fruit, impartial and sincere.', 'James 3:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the businesses in this region, that they would operate with a spirit of generosity and serve their communities well.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 6:38', 'prayer-global-porch' ),
                'verse' => _x( 'Give, and it will be given to you. A good measure, pressed down, shaken together and running over, will be poured into your lap. For with the measure you use, it will be measured to you.', 'Luke 6:38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are burdened with heavy workloads in this region, that You would give them rest and balance in their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 11:28-29', 'prayer-global-porch' ),
                'verse' => _x( 'Come to me, all you who are weary and burdened, and I will give you rest. Take my yoke upon you and learn from me, for I am gentle and humble in heart, and you will find rest for your souls.', 'Matthew 11:28-29', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the leaders in this region, that they would be wise, humble, and lead with a servant’s heart.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 20:26-28', 'prayer-global-porch' ),
                'verse' => _x( 'Whoever wants to become great among you must be your servant, and whoever wants to be first must be your slave—just as the Son of Man did not come to be served, but to serve, and to give his life as a ransom for many.', 'Matthew 20:26-28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the media in this region, that the truth of the gospel would be broadcast and reach many hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 24:14', 'prayer-global-porch' ),
                'verse' => _x( 'And this gospel of the kingdom will be preached in the whole world as a testimony to all nations, and then the end will come.', 'Matthew 24:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the small businesses in this region, that they would thrive and be a positive influence in their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:21', 'prayer-global-porch' ),
                'verse' => _x( 'His master replied, ‘Well done, good and faithful servant! You have been faithful with a few things; I will put you in charge of many things. Come and share your master’s happiness!’', 'Matthew 25:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the healthcare workers in this region, that they would be strengthened and filled with compassion to care for the sick.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:36', 'prayer-global-porch' ),
                'verse' => _x( 'I needed clothes and you clothed me, I was sick and you looked after me, I was in prison and you came to visit me.’', 'Matthew 25:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the healthcare workers in this region, that You would protect and guide them as they care for others.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:36', 'prayer-global-porch' ),
                'verse' => _x( 'I needed clothes and you clothed me, I was sick and you looked after me, I was in prison and you came to visit me.’', 'Matthew 25:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those working in the healthcare industry in this region, that they would bring healing and compassion to all in need.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:36', 'prayer-global-porch' ),
                'verse' => _x( 'I needed clothes and you clothed me, I was sick and you looked after me, I was in prison and you came to visit me.’', 'Matthew 25:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the healthcare workers in this region, that You would protect them and give them strength as they care for the sick.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:36', 'prayer-global-porch' ),
                'verse' => _x( 'I needed clothes and you clothed me, I was sick and you looked after me, I was in prison and you came to visit me.’', 'Matthew 25:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the healthcare workers in this region, that You would strengthen and protect them as they serve those in need.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:40', 'prayer-global-porch' ),
                'verse' => _x( 'The King will reply, ‘Truly I tell you, whatever you did for one of the least of these brothers and sisters of mine, you did for me.’', 'Matthew 25:40', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the businesses in this region, that they would honor You with their practices and use their resources to bless others.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:33', 'prayer-global-porch' ),
                'verse' => _x( 'But seek first his kingdom and his righteousness, and all these things will be given to you as well.', 'Matthew 6:33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those seeking employment in this region, that You would open doors and provide opportunities for gainful work.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 7:7', 'prayer-global-porch' ),
                'verse' => _x( 'Ask and it will be given to you; seek and you will find; knock and the door will be opened to you.', 'Matthew 7:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the hospitals and healthcare facilities in this region, that they would provide excellent care to the sick and injured.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 9:12', 'prayer-global-porch' ),
                'verse' => _x( 'On hearing this, Jesus said, ‘It is not the healthy who need a doctor, but the sick.’', 'Matthew 9:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the community leaders in this region, that they would govern with justice and mercy, reflecting Your character.', 'prayer-global-porch' ),
                'reference' => __( 'Micah 6:8', 'prayer-global-porch' ),
                'verse' => _x( 'He has shown you, O mortal, what is good. And what does the Lord require of you? To act justly and to love mercy and to walk humbly with your God.', 'Micah 6:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those involved in the legal system in this region, that they would act justly and with integrity.', 'prayer-global-porch' ),
                'reference' => __( 'Micah 6:8', 'prayer-global-porch' ),
                'verse' => _x( 'He has shown you, O mortal, what is good. And what does the Lord require of you? To act justly and to love mercy and to walk humbly with your God.', 'Micah 6:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those working in the legal profession in this region, that they would pursue justice with integrity and fairness.', 'prayer-global-porch' ),
                'reference' => __( 'Micah 6:8', 'prayer-global-porch' ),
                'verse' => _x( 'He has shown you, O mortal, what is good. And what does the Lord require of you? To act justly and to love mercy and to walk humbly with your God.', 'Micah 6:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would guide the leaders in this region to govern with justice, mercy, and humility.', 'prayer-global-porch' ),
                'reference' => __( 'Micah 6:8', 'prayer-global-porch' ),
                'verse' => _x( 'He has shown you, O mortal, what is good. And what does the Lord require of you? To act justly and to love mercy and to walk humbly with your God.', 'Micah 6:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would raise up leaders in this region who will stand firm for justice, righteousness, and peace.', 'prayer-global-porch' ),
                'reference' => __( 'Micah 6:8', 'prayer-global-porch' ),
                'verse' => _x( 'He has shown you, O mortal, what is good. And what does the Lord require of you? To act justly and to love mercy and to walk humbly with your God.', 'Micah 6:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the unemployed in this region, that You would open doors for them and provide meaningful work that allows them to serve You and others.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the unemployed in this region, that You would open doors of opportunity and provide meaningful work for them.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for Your provision for the unemployed in this region, that they would find meaningful work that glorifies You.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the arts and entertainment industry in this region, that it would reflect Your truth and bring glory to Your name.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:8', 'prayer-global-porch' ),
                'verse' => _x( 'Finally, brothers and sisters, whatever is true, whatever is noble, whatever is right, whatever is pure, whatever is lovely, whatever is admirable—if anything is excellent or praiseworthy—think about such things.', 'Philippians 4:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask that You would bless the schools in this region, that students would grow in knowledge and love for You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of knowledge, but fools despise wisdom and instruction. Proverbs 1:7', 'Proverbs 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the education system in this region, that teachers and administrators would provide students with opportunities to grow both intellectually and spiritually.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of knowledge, but fools despise wisdom and instruction. Proverbs 1:7', 'Proverbs 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the businesses in this region, that they would conduct their operations with integrity and be a blessing to the community.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 11:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord detests dishonest scales, but accurate weights find favor with him.', 'Proverbs 11:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the business leaders in this region, that they would operate their businesses with integrity and use their resources for good.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 11:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord detests dishonest scales, but accurate weights find favor with him.', 'Proverbs 11:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the businesses in this region, that they may operate with integrity and contribute to the welfare of the community.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 11:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord detests dishonest scales, but accurate weights find favor with him.', 'Proverbs 11:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the community leaders in this region, that they would lead with wisdom and understanding, always seeking the good of others.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 11:14', 'prayer-global-porch' ),
                'verse' => _x( 'For lack of guidance a nation falls, but victory is won through many advisers.', 'Proverbs 11:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the business leaders in this region, that they would lead with integrity and honor You in all their dealings.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 11:3', 'prayer-global-porch' ),
                'verse' => _x( 'The integrity of the upright guides them, but the unfaithful are destroyed by their duplicity.', 'Proverbs 11:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the media in this region, that it would convey truth and promote justice, peace, and compassion.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 12:22', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord detests lying lips, but he delights in people who are trustworthy.', 'Proverbs 12:22', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those in leadership in this region, that they would lead with integrity, justice, and compassion.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:12', 'prayer-global-porch' ),
                'verse' => _x( 'Kings detest wrongdoing, for a throne is established through righteousness.', 'Proverbs 16:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would raise up leaders in this region who are passionate about justice and righteousness, leading with Your wisdom.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:12', 'prayer-global-porch' ),
                'verse' => _x( 'Kings detest wrongdoing, for a throne is established through righteousness.', 'Proverbs 16:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the business leaders in this region, that they would operate with integrity, honesty, and a heart for service.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:3', 'prayer-global-porch' ),
                'verse' => _x( 'Commit to the Lord whatever you do, and he will establish your plans.', 'Proverbs 16:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the business owners in this region, that they would lead with integrity and honor You in their work.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:3', 'prayer-global-porch' ),
                'verse' => _x( 'Commit to the Lord whatever you do, and he will establish your plans.', 'Proverbs 16:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the entrepreneurs in this region, that they would use their creativity and resources for Your glory.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:3', 'prayer-global-porch' ),
                'verse' => _x( 'Commit to the Lord whatever you do, and he will establish your plans.', 'Proverbs 16:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the businesses in this region, that they would prosper and be a source of blessing to their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:3', 'prayer-global-porch' ),
                'verse' => _x( 'Commit to the Lord whatever you do, and he will establish your plans.', 'Proverbs 16:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the entrepreneurs in this region, that they would honor You in their work and bless the community.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:3', 'prayer-global-porch' ),
                'verse' => _x( 'Commit to the Lord whatever you do, and he will establish your plans.', 'Proverbs 16:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the local businesses in this region, that they would thrive and serve the community with integrity.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:3', 'prayer-global-porch' ),
                'verse' => _x( 'Commit to the Lord whatever you do, and he will establish your plans.', 'Proverbs 16:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the leaders of businesses in this region, that they would be ethical, fair, and compassionate in their work.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:8', 'prayer-global-porch' ),
                'verse' => _x( 'Better a little with righteousness than much gain with injustice.', 'Proverbs 16:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the hearts of the leaders in this region, that they would seek You and lead with wisdom, integrity, and love.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the leaders in this region, that You would grant them wisdom and discernment to lead according to Your will.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those working in law enforcement in this region, that they would serve with integrity and wisdom, bringing justice to all.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:15', 'prayer-global-porch' ),
                'verse' => _x( 'When justice is done, it brings joy to the righteous but terror to evildoers.', 'Proverbs 21:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those working in the justice system in this region, that they would uphold fairness and righteousness in all they do.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:15', 'prayer-global-porch' ),
                'verse' => _x( 'When justice is done, it brings joy to the righteous but terror to evildoers.', 'Proverbs 21:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would raise up leaders in this region who will seek justice and righteousness for all people.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:3', 'prayer-global-porch' ),
                'verse' => _x( 'To do what is right and just is more acceptable to the Lord than sacrifice.', 'Proverbs 21:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray that the government leaders in this country would do what is right and lead with justice and integrity.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 21:3', 'prayer-global-porch' ),
                'verse' => _x( 'To do what is right and just is more acceptable to the Lord than sacrifice.', 'Proverbs 21:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the parents in this region, that they would raise their children in the fear and knowledge of You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the teachers in this region, that they would be equipped to teach with wisdom and love.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the schools in this region, that they would be environments of learning and growth, where truth is valued.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the leaders of this region, that they would govern with wisdom, justice, and compassion for all people.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 29:2', 'prayer-global-porch' ),
                'verse' => _x( 'When the righteous thrive, the people rejoice; when the wicked rule, the people groan.', 'Proverbs 29:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the government leaders in this region, that they would lead with wisdom, integrity, and righteousness.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 29:2', 'prayer-global-porch' ),
                'verse' => _x( 'When the righteous thrive, the people rejoice; when the wicked rule, the people groan.', 'Proverbs 29:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the entrepreneurs in this region, that You would guide their business ventures, that they would use their resources to bless others and glorify You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the business leaders in this region, that they would manage their resources wisely and seek the welfare of others.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:9', 'prayer-global-porch' ),
                'verse' => _x( 'Honor the Lord with your wealth, with the firstfruits of all your crops;', 'Proverbs 3:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may Your presence be felt powerfully in the schools of this region, drawing both students and teachers to know You.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 25:5', 'prayer-global-porch' ),
                'verse' => _x( 'Guide me in your truth and teach me, for you are God my Savior, and my hope is in you all day long.', 'Psalm 25:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the people in this region who are in positions of influence, that they would use their authority to bring about good and honor You.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 13:1', 'prayer-global-porch' ),
                'verse' => _x( 'Let everyone be subject to the governing authorities, for there is no authority except that which God has established. The authorities that exist have been established by God.', 'Romans 13:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the government leaders in this region, that they would seek justice and work for the good of the people.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 13:1', 'prayer-global-porch' ),
                'verse' => _x( 'Let everyone be subject to the governing authorities, for there is no authority except that which God has established. The authorities that exist have been established by God.', 'Romans 13:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those involved in public service in this region, that they would act justly and serve with integrity.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 13:3-4', 'prayer-global-porch' ),
                'verse' => _x( 'For rulers hold no terror for those who do right, but for those who do wrong. Do you want to be free from fear of the one in authority? Then do what is right and you will be commended. For the one in authority is God’s servant for your good. But if you do wrong, be afraid, for rulers do not bear the sword for no reason. They are God’s servants, agents of wrath to bring punishment on the wrongdoer.', 'Romans 13:3-4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the police officers in this region, that they would serve with integrity and protect their communities.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 13:4', 'prayer-global-porch' ),
                'verse' => _x( 'For the one in authority is God’s servant for your good. But if you do wrong, be afraid, for rulers do not bear the sword for no reason. They are God’s servants, agents of wrath to bring punishment on the wrongdoer.', 'Romans 13:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those who are in positions of authority in this region, that they would seek to serve the people with integrity and justice.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 13:4', 'prayer-global-porch' ),
                'verse' => _x( 'For the one in authority is God’s servant for your good. But if you do wrong, be afraid, for rulers do not bear the sword for no reason. They are God’s servants, agents of wrath to bring punishment on the wrongdoer.', 'Romans 13:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, help the leaders of this country seek Your wisdom and truth in their decisions.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 14:16', 'prayer-global-porch' ),
                'verse' => _x( 'The wise fear the Lord and shun evil, but a fool is hotheaded and yet feels secure.', 'Proverbs 14:16', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_apostolic_pioneering_leadership( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) { // local leadership and lay leadership
        $section_label = __( 'Apostles and Pioneers', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please raise up new apostles to pioneer the growth of the church in %s.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( 'Ephesians 4:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'So Christ himself gave the apostles, the prophets, the evangelists, the pastors and teachers, to equip his people for works of service, so that the body of Christ may be built up', 'Ephesians 4:11-12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, raise up apostolic workers to plant churches in every town in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Titus 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'The reason I left you in Crete was that you might put in order what was left unfinished and appoint elders in every town, as I directed you.', 'Titus 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please send new apostles into the harvest, who can open up new communities for the gospel in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 9:38', 'prayer-global-porch' ),
                'verse' => _x( 'Ask the Lord of the harvest, therefore, to send out workers into his harvest field.', 'Matthew 9:38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, please give the apostles in %1$s a vision for the harvest, and a passion to see the gospel spread to every corner of the %2$s.', 'prayer-global-porch' ), $stack['location']['full_name'], $stack['location']['admin_level_title'] ),
                'reference' => __( 'Ephesians 4:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'So Christ himself gave the apostles, the prophets, the evangelists, the pastors and teachers, to equip his people for works of service, so that the body of Christ may be built up', 'Ephesians 4:11-12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord of the Harvest, please send out workers into the %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 9:37-38', 'prayer-global-porch' ),
                'verse' => _x( 'Then he said to his disciples, “The harvest is plentiful but the workers are few. Ask the Lord of the harvest, therefore, to send out workers into his harvest field.', 'Matthew 9:37-38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, please give apostles to expand the church into every neighborhood of %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 28:19-20a', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit, and teaching them to obey everything I have commanded you.', 'Matthew 28:19-20a', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for protection over the missionaries in this region. May they be strong in your power and filled with the courage to continue the work you have called them to.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'Finally, be strong in the Lord and in his mighty power.', 'Ephesians 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask that You would pour out Your Holy Spirit upon the churches in this region, enabling them to preach the gospel with power and conviction.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses in Jerusalem, and in all Judea and Samaria, and to the ends of the earth.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would raise up missionaries from this region who will take the gospel to the unreached peoples of the world.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 6:8', 'prayer-global-porch' ),
                'verse' => _x( 'Then I heard the voice of the Lord saying, ‘Whom shall I send? And who will go for us?’ And I said, ‘Here am I. Send me!’', 'Isaiah 6:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would raise up more laborers in this region to spread the gospel and make disciples.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 9:37-38', 'prayer-global-porch' ),
                'verse' => _x( 'Then he said to his disciples, ‘The harvest is plentiful but the workers are few. Ask the Lord of the harvest, therefore, to send out workers into his harvest field.’', 'Matthew 9:37-38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the missionaries in this region, that You would strengthen their hearts and fill them with Your joy and peace.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:13', 'prayer-global-porch' ),
                'verse' => _x( 'I can do all this through him who gives me strength.', 'Philippians 4:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the families of missionaries in this region, that they would experience Your peace, provision, and strength.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would raise up strong, godly leaders in this region who will lead with humility and wisdom.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_evangelistic_leadership( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Evangelists and Harvest Workers', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, please raise up evangelists to equip your people to share the gospel in %1$s.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( 'Ephesians 4:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'So Christ himself gave the apostles, the prophets, the evangelists, the pastors and teachers, to equip his people for works of service, so that the body of Christ may be built up', 'Ephesians 4:11-12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please send new evangelists into the harvest in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 9:38', 'prayer-global-porch' ),
                'verse' => _x( 'Ask the Lord of the harvest, therefore, to send out workers into his harvest field.', 'Matthew 9:38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, you said you were the giver of evangelists to the church. Please, send more evangelists to %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'Ephesians 4:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'So Christ himself gave the apostles, the prophets, the evangelists, the pastors and teachers, to equip his people for works of service, so that the body of Christ may be built up', 'Ephesians 4:11-12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => __( 'Evangelists', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'God in Heaven, only you can and should appoint evangelists. Please, appoint and send more to %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( '1 Corinthians 12:28', 'prayer-global-porch' ),
                'verse' => _x( 'And in the church God has appointed first of all apostles, second prophets, third teachers, then workers of miracles, and those with gifts of healing, helping, administration, and various tongues.', '1 Corinthians 12:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, encourage every believer in %1$s to do the work of an evangelist with their friends and neighbors.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( '2 Timothy 4:5', 'prayer-global-porch' ),
                'verse' => _x( 'But you, keep your head in all situations, endure hardship, do the work of an evangelist', '2 Timothy 4:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, help every believer in %1$s be prepared to give an answer to everyone who asks them for the reason for their hope.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( '1 Peter 3:15', 'prayer-global-porch' ),
                'verse' => _x( 'But in your hearts revere Christ as Lord. Always be prepared to give an answer to everyone who asks you to give the reason for the hope that you have. But do this with gentleness and respect.', '1 Peter 3:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, send out evangelists who will challenge people like Peter who said, "Repent and be baptized, every one of you" in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'Acts 2:38', 'prayer-global-porch' ),
                'verse' => _x( 'Peter replied, “Repent and be baptized, every one of you, in the name of Jesus Christ for the forgiveness of your sins. And you will receive the gift of the Holy Spirit.', 'Acts 2:38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, please give your people in %1$s a passion for the lost.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( '2 Corinthians 5:20', 'prayer-global-porch' ),
                'verse' => _x( 'We are therefore Christ’s ambassadors, as though God were making his appeal through us. We implore you on Christ’s behalf: Be reconciled to God.', '2 Corinthians 5:20', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, raise up faithful witnesses who will boldly proclaim your Word to the unreached.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 10:14', 'prayer-global-porch' ),
                'verse' => _x( 'How, then, can they call on the one they have not believed in? And how can they believe in the one of whom they have not heard? And how can they hear without someone preaching to them?', 'Romans 10:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for Your guidance for the missionaries in this region, that they would be empowered by Your Spirit to share the gospel effectively.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses in Jerusalem, and in all Judea and Samaria, and to the ends of the earth.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask that You would pour out Your Spirit on the churches in this region, awakening them to a passion for evangelism and missions.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'But you will receive power when the Holy Spirit comes on you; and you will be my witnesses in Jerusalem, and in all Judea and Samaria, and to the ends of the earth.', 'Acts 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for Your presence to go with the missionaries in this region, empowering them to share the gospel with courage and love.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 28:19-20', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit, and teaching them to obey everything I have commanded you. And surely I am with you always, to the very end of the age.', 'Matthew 28:19-20', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_prophetic_leadership( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Prophets and Truth Speakers', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please raise up prophets in %1$s who can call the church to holiness and purity, preparing your church as a bride for your Son.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( 'Ephesians 4:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'So Christ himself gave the apostles, the prophets, the evangelists, the pastors and teachers, to equip his people for works of service, so that the body of Christ may be built up', 'Ephesians 4:11-12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please give the church in %1$s of %2$s prophets who can build up holiness and faithfulness to you.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Ephesians 4:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'So Christ himself gave the apostles, the prophets, the evangelists, the pastors and teachers, to equip his people for works of service, so that the body of Christ may be built up', 'Ephesians 4:11-12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, you already know the names of the prophets you want to raise up in %1$s. Please, raise them up and give them the courage to speak your truth to your church.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( 'Jeremiah 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'Before I formed you in the womb I knew you, and before you were born I consecrated you; I appointed you a prophet to the nations.', 'Jeremiah 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, like in the church of Antioch, where you gathered many prophets and teachers, please gather many prophets and teachers in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'Acts 13:1', 'prayer-global-porch' ),
                'verse' => _x( 'Now in the church at Antioch there were prophets and teachers: Barnabas, Simeon called Niger, Lucius of Cyrene, Manaen (who had been brought up with Herod the tetrarch), and Saul.', 'Acts 13:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, make bold the prophets in %1$s so that the church can be equipped with truth and insight and a vision of your heart.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Zechariah 8:16', 'prayer-global-porch' ),
                'verse' => _x( 'These are the things which you should do: speak the truth to one another; judge with truth and judgment for peace in your gates.', 'Zechariah 8:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, raise up prophets and truth speakers in your church in %1$s so that the church can grow in every way into the mature body of you its head.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Ephesians 4:15', 'prayer-global-porch' ),
                'verse' => _x( 'Instead, speaking the truth in love, we will grow to become in every respect the mature body of him who is the head, that is, Christ.', 'Ephesians 4:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, make the church in %1$s humble and willing to hear the sometimes hard voices of prophets bringing the light of truth on them.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Galatians 4:16', 'prayer-global-porch' ),
                'verse' => _x( 'So have I become your enemy by telling you the truth?', 'Galatians 4:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, strengthen the church in %1$s by giving a prophet, as you said you would, who is bold and willing to correct. Lord, may the believers care about holiness as you do.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Ephesians 4:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'So Christ himself gave the apostles, the prophets, the evangelists, the pastors and teachers, to equip his people for works of service, so that the body of Christ may be built up', 'Ephesians 4:11-12', 'prayer-global-porch' ),
            ],
        ];

        $ai_templates = [];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_shepherding_leadership( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Shepherds and Pastors', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, give grace to the local leaders who shepherd the %1$s believers in %2$s of %3$s.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'John 10:11', 'prayer-global-porch' ),
                'verse' => _x( 'I am the good shepherd. The good shepherd lays down his life for the sheep.', 'John 10:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, please provide elders whose hearts are completely yours in every town in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Titus 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'The reason I left you in Crete was that you might put in order what was left unfinished and appoint elders in every town, as I directed you.', 'Titus 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, please bless the leaders of the %1$s of %2$s who work hard at shepherding and guiding your people.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'Psalm 78:72', 'prayer-global-porch' ),
                'verse' => _x( 'With upright heart he shepherded them and guided them with his skillful hand.', 'Psalm 78:72', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, encourage every one of the %1$s ordinary believers here to care for others, like a shepherd cares for his sheep.', 'prayer-global-porch' ), $stack['location']['believers'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, you gave the church of %1$s the greatest shepherd of all time, Jesus. Please, help them listen to him.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Ezekiel 34:23', 'prayer-global-porch' ),
                'verse' => _x( 'I will place over them one shepherd, my servant David, and he will tend them; he will tend them and be their shepherd.', 'Ezekiel 34:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, for all those you call to look after your flock from the %1$s believers in %2$s, please, make them passionate about hearing your Word.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => __( 'Ezekiel 34:7', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore, you shepherds, hear the word of the LORD.', 'Ezekiel 34:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Good Shepherd, thank you that you know the name of each of the %1$s believers in %2$s.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => __( 'John 10:14', 'prayer-global-porch' ),
                'verse' => _x( 'I am the good shepherd; I know my sheep and my sheep know me', 'John 10:14', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for spiritual leaders in this country to have wisdom and courage as they shepherd their flocks.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 5:2', 'prayer-global-porch' ),
                'verse' => _x( 'Be shepherds of God’s flock that is under your care, watching over them—not because you must, but because you are willing, as God wants you to be; not pursuing dishonest gain, but eager to serve;', '1 Peter 5:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the spiritual leaders in this region, that they would shepherd your people with wisdom, integrity, and love.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 5:2', 'prayer-global-porch' ),
                'verse' => _x( 'Be shepherds of God’s flock that is under your care, watching over them—not because you must, but because you are willing, as God wants you to be; not pursuing dishonest gain, but eager to serve;', '1 Peter 5:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, raise up leaders who will shepherd your people with wisdom, humility, and love.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 5:2', 'prayer-global-porch' ),
                'verse' => _x( 'Be shepherds of God’s flock that is under your care, watching over them—not because you must, but because you are willing, as God wants you to be; not pursuing dishonest gain, but eager to serve;', '1 Peter 5:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the churches in this region to be places of refuge and healing for the brokenhearted.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 4:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Lord is on me, because he has anointed me to proclaim good news to the poor.', 'Luke 4:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray that the Church in this region would be a place of refuge for those in need, offering help and hope to the hurting.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 61:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Sovereign Lord is on me, because the Lord has anointed me to proclaim good news to the poor.', 'Isaiah 61:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the pastors in this region, that You would strengthen them in their leadership and guide them with Your Word.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 5:2', 'prayer-global-porch' ),
                'verse' => _x( 'Be shepherds of God’s flock that is under your care, watching over them—not because you must, but because you are willing, as God wants you to be.', '1 Peter 5:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would raise up faithful leaders in this region to shepherd Your flock with wisdom and love.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 5:2-3', 'prayer-global-porch' ),
                'verse' => _x( 'Be shepherds of God’s flock that is under your care, watching over them—not because you must, but because you are willing, as God wants you to be; not pursuing dishonest gain, but eager to serve; not lording it over those entrusted to you, but being examples to the flock.', '1 Peter 5:2-3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the leadership of the church in this region, that they would be filled with wisdom and love for the flock.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 5:2-3', 'prayer-global-porch' ),
                'verse' => _x( 'Be shepherds of God’s flock that is under your care, watching over them—not because you must, but because you are willing, as God wants you to be; not pursuing dishonest gain, but eager to serve; not lording it over those entrusted to you, but being examples to the flock.', '1 Peter 5:2-3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the pastors and leaders in this region, that they would lead with wisdom and humility, shepherding Your flock well.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 5:2-3', 'prayer-global-porch' ),
                'verse' => _x( 'Be shepherds of God’s flock that is under your care, watching over them—not because you must, but because you are willing, as God wants you to be; not pursuing dishonest gain, but eager to serve; not lording it over those entrusted to you, but being examples to the flock.', '1 Peter 5:2-3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are struggling with fear in this region, that they would find peace and trust in Your promises.', 'prayer-global-porch' ),
                'reference' => __( '2 Timothy 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'For the Spirit God gave us does not make us timid, but gives us power, love and self-discipline.', '2 Timothy 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the children in this region, that they would come to know You at a young age and grow up in the knowledge of Your love.', 'prayer-global-porch' ),
                'reference' => __( '2 Timothy 3:15', 'prayer-global-porch' ),
                'verse' => _x( 'And how from infancy you have known the holy Scriptures, which are able to make you wise for salvation through faith in Christ Jesus.', '2 Timothy 3:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the pastors and teachers in this region, that they may boldly preach Your Word and shepherd Your people with love.', 'prayer-global-porch' ),
                'reference' => __( '2 Timothy 4:2', 'prayer-global-porch' ),
                'verse' => _x( 'Preach the word; be prepared in season and out of season; correct, rebuke and encourage—with great patience and careful instruction.', '2 Timothy 4:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the pastors in this region, that they would be filled with the knowledge of Your will and lead Your people with grace.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 1:17', 'prayer-global-porch' ),
                'verse' => _x( 'I keep asking that the God of our Lord Jesus Christ, the glorious Father, may give you the Spirit of wisdom and revelation, so that you may know him better.', 'Ephesians 1:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that Your Holy Spirit would move in the hearts of the leaders in this region, giving them wisdom to lead well.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the church leaders in this region, that they would be filled with wisdom and discernment to shepherd Your flock well.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask for Your wisdom to guide the pastors in this region as they shepherd Your people, teaching them with truth and love.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask that You would bless the ministry leaders in this region, that they may lead with wisdom, courage, and compassion.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the pastors in this region, that they would be filled with Your wisdom and a deep love for Your people.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 3:15', 'prayer-global-porch' ),
                'verse' => _x( 'Then I will give you shepherds after my own heart, who will lead you with knowledge and understanding.', 'Jeremiah 3:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray that Your church in this region will be a place of refuge, compassion, and healing for those who are hurting.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 11:28', 'prayer-global-porch' ),
                'verse' => _x( 'Come to me, all you who are weary and burdened, and I will give you rest.', 'Matthew 11:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the young mothers in this region, that You would empower them to raise their children in the fear and knowledge of You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the parents of young children in this region, that You would give them wisdom and patience in raising their children.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the parents who are struggling with balancing work and family life in this region, that You would give them wisdom and strength.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the youth leaders in this region, that they would be filled with wisdom and passion to guide the next generation in Your truth.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:23', 'prayer-global-porch' ),
                'verse' => _x( 'Above all else, guard your heart, for everything you do flows from it.', 'Proverbs 4:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the church in this region to be a refuge for the hurting and a place of restoration for those in need.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the elderly in this region, that they may find joy in their years and be surrounded by loving care.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 71:9', 'prayer-global-porch' ),
                'verse' => _x( 'Do not cast me away when I am old; do not forsake me when my strength is gone.', 'Psalm 71:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the elderly in this region, that they would feel valued and be cared for in their later years.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 92:14', 'prayer-global-porch' ),
                'verse' => _x( 'They will still bear fruit in old age, they will stay fresh and green,', 'Psalm 92:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the elderly in this region, that they would experience Your peace, comfort, and joy in their later years.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 92:14', 'prayer-global-porch' ),
                'verse' => _x( 'They will still bear fruit in old age, they will stay fresh and green,', 'Psalm 92:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the elderly in this region, that You would bless them with strength, dignity, and peace.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 92:14', 'prayer-global-porch' ),
                'verse' => _x( 'They will still bear fruit in old age, they will stay fresh and green,', 'Psalm 92:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the elderly in this region, that You would surround them with love and care in their later years.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 92:14', 'prayer-global-porch' ),
                'verse' => _x( 'They will still bear fruit in old age, they will stay fresh and green,', 'Psalm 92:14', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_teaching_leadership( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Teachers', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please send teachers of your Word in %1$s who can speak your gospel boldly and clearly.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, build the strength and maturity of the local leaders in %1$s. Show them that faithfulness is more important than knowledge. Show them that the Spirit, the Word, and prayer is enough in order to grow and lead. ', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, for the leaders in %1$s of %2$s, let the eyes of their hearts be enlightened in order that they may know the hope to which they are called.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Ephesians 1:18-19a', 'prayer-global-porch' ),
                'verse' => _x( 'I pray that the eyes of your heart may be enlightened in order that you may know the hope to which he has called you, the riches of his glorious inheritance in his holy people, and his incomparably great power for us who believe. ', 'Ephesians 1:18-19a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please send new teachers into the harvest, who can correct the lies of our enemy in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 9:38', 'prayer-global-porch' ),
                'verse' => _x( 'Ask the Lord of the harvest, therefore, to send out workers into his harvest field.', 'Matthew 9:38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, the believers in %1$s of %2$s need teachers who can feed them with knowledge and understanding. Please raise them up.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['full_name'] ),
                'reference' => __( 'Jeremiah 3:15', 'prayer-global-porch' ),
                'verse' => _x( 'Then I will give you shepherds after My own heart, who will feed you with knowledge and understanding.', 'Jeremiah 3:15', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for wisdom for the educators in this region, that they would teach with clarity, patience, and integrity.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'let the wise listen and add to their learning, and let the discerning get guidance', 'Proverbs 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for wisdom and discernment for the educators in this region, that they may impart truth and knowledge to the next generation.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'let the wise listen and add to their learning, and let the discerning get guidance', 'Proverbs 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for wisdom for the educators in this region. May they teach with integrity and inspire a love for truth in their students.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of knowledge, but fools despise wisdom and instruction.', 'Proverbs 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the educational system in this region, that it would foster a generation that seeks truth, wisdom, and knowledge.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 9:10', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of wisdom, and knowledge of the Holy One is understanding.', 'Proverbs 9:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We ask that the schools in this region would cultivate hearts and minds that seek knowledge and grow in understanding.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 9:10', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of wisdom, and knowledge of the Holy One is understanding.', 'Proverbs 9:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the education system in this region, that it would be a place where truth and wisdom flourish.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 111:10', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of wisdom; all who follow his precepts have good understanding. To him belongs eternal praise.', 'Psalm 111:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray that the educational system in this region would nurture truth and wisdom, providing a foundation for the next generation.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 111:10', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of wisdom; all who follow his precepts have good understanding. To him belongs eternal praise.', 'Psalm 111:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the universities in this region, that students and faculty would seek your truth and wisdom in all things.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 9:10', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of wisdom, and knowledge of the Holy One is understanding.', 'Proverbs 9:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the education system in this region, that it would foster wisdom and understanding.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 9:10', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of wisdom, and knowledge of the Holy One is understanding.', 'Proverbs 9:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the youth leaders in this region, that they would disciple young people to live boldly for Christ.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would raise up new leaders in this region who will passionately serve You and lead others to Christ.', 'prayer-global-porch' ),
                'reference' => __( '2 Timothy 2:2', 'prayer-global-porch' ),
                'verse' => _x( 'And the things you have heard me say in the presence of many witnesses entrust to reliable people who will also be qualified to teach others.', '2 Timothy 2:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for teachers in this region, that they would inspire their students to love You and live according to Your Word.', 'prayer-global-porch' ),
                'reference' => __( '2 Timothy 2:2', 'prayer-global-porch' ),
                'verse' => _x( 'And the things you have heard me say in the presence of many witnesses entrust to reliable people who will also be qualified to teach others.', '2 Timothy 2:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the youth in this region, that they may grow in wisdom and understanding, and be strong in faith.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith, and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the teachers and educators in this region, that they would be equipped with wisdom and patience to teach effectively.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of knowledge, but fools despise wisdom and instruction. Proverbs 1:7', 'Proverbs 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the schools in this region, that teachers and students alike would know Your truth and walk in wisdom.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the universities and colleges in this region, that they would be places of learning and spiritual awakening.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your guidance and protection for the students in this region, that they would be guided in truth and knowledge.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would pour out Your Spirit on the schools in this region, that they would be places where truth, love, and knowledge abound.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 2:6', 'prayer-global-porch' ),
                'verse' => _x( 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'Proverbs 2:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the educators in this region, that they would teach with passion, patience, and wisdom, impacting the lives of their students.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 22:6', 'prayer-global-porch' ),
                'verse' => _x( 'Start children off on the way they should go, and even when they are old they will not turn from it.', 'Proverbs 22:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the teachers in this region, that they would be wise and compassionate, guiding students with truth.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:13', 'prayer-global-porch' ),
                'verse' => _x( 'Hold on to instruction, do not let it go; guard it well, for it is your life.', 'Proverbs 4:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the teachers in this region, that they would be equipped to inspire and guide the next generation with knowledge and wisdom.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:13', 'prayer-global-porch' ),
                'verse' => _x( 'Hold on to instruction, do not let it go; guard it well, for it is your life.', 'Proverbs 4:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the teachers in this region, that they would teach with grace, kindness, and integrity, guiding students to knowledge and understanding.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the teachers in this region, that You would equip them with wisdom and patience to guide their students in truth and love.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for Your wisdom to guide the educators in this region, that they may teach with excellence and love.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would bless the teachers in this region, giving them the wisdom and patience needed to shape young minds.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the educators in this region, that You would empower them to teach with wisdom, patience, and love.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your wisdom and discernment for those making decisions about education in this region, that they would prioritize the well-being and development of children.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the education system in this region, that it would foster environments of learning and wisdom for all students.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the educators in this region, that they would be wise and compassionate in their teaching, guiding students to knowledge and truth.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.', 'Proverbs 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those involved in education in this region, that they would impart knowledge with wisdom and integrity.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 9:10', 'prayer-global-porch' ),
                'verse' => _x( 'The fear of the Lord is the beginning of wisdom, and knowledge of the Holy One is understanding.', 'Proverbs 9:10', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }


    public static function _for_biblical_authority( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Biblical Authority', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, make the Word of God a delight to the people of %1$s, like it was to David.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:16', 'prayer-global-porch' ),
                'verse' => _x( 'I delight in your decrees; I will not neglect your Word.', 'Psalm 119:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, instill a desire within the people of %1$s of %2$s to hide your Word in their heart.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:11', 'prayer-global-porch' ),
                'verse' => _x( 'I have hidden your Word in my heart that I might not sin against you.', 'Psalm 119:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, help the people of the %1$s of %2$s to be consumed with longing for your Word at all times, like David.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:20', 'prayer-global-porch' ),
                'verse' => _x( 'My soul is consumed with longing for your laws at all times.', 'Psalm 119:20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, teach your Word to the people of the %1$s of %2$s, so that they can follow your ways all their life.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:33', 'prayer-global-porch' ),
                'verse' => _x( 'Teach me, Lord, the way of your decrees, that I may follow it to the end.', 'Psalm 119:33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, teach the disciples in %1$s of %2$s to trust your Word, like a lamp, in the darkness around them.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:105', 'prayer-global-porch' ),
                'verse' => _x( 'your Word is a lamp for my feet, a light on my path.', 'Psalm 119:105', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, teach the young people in %1$s of %2$s to trust your Word and find the path of purity.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:9', 'prayer-global-porch' ),
                'verse' => _x( 'How can a young person stay on the path of purity? By living according to your word.', 'Psalm 119:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, we know that cultures come and go, even in %1$s of %2$s, but the truth of your Word endures generations.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:89', 'prayer-global-porch' ),
                'verse' => _x( 'Your Word, Lord, is eternal; it stands firm in the heavens.', 'Psalm 119:89', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, defend those who are loyal to your Word in %1$s of %2$s, even against fierce enemies.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:61', 'prayer-global-porch' ),
                'verse' => _x( 'Though the wicked bind me with ropes, I will not forget your law.', 'Psalm 119:61', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, fill the %1$s souls living in %2$s of %3$s with a taste for your Word. Make it sweet as honey in their mouth.', 'prayer-global-porch' ), $stack['location']['population'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:103', 'prayer-global-porch' ),
                'verse' => _x( 'How sweet are your words to my taste, sweeter than honey to my mouth!', 'Psalm 119:103', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, fill the %1$s believers in %2$s of %3$s with tears, because God is not obeyed by those around them.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:136', 'prayer-global-porch' ),
                'verse' => _x( 'Streams of tears flow from my eyes, for your law is not obeyed.', 'Psalm 119:136', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, guide the %1$s believers in %2$s of %3$s into all truth as they interpret Scriptures.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Hebrews 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'For the word of God is alive and active. Sharper than any double-edged sword, it penetrates even to dividing soul and spirit, joints and marrow;', 'Hebrews 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, we pray that the people of %1$s will learn to study the Bible, understand it, obey it, and share it.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, let knowledge and depth of insight abound more and more in the church of %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Philippians 1:9', 'prayer-global-porch' ),
                'verse' => _x( 'And this is my prayer: that your love may abound more and more in knowledge and depth of insight,', 'Philippians 1:9', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that your truth would penetrate the hearts of the people in this region, setting them free from deception.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:32', 'prayer-global-porch' ),
                'verse' => _x( 'Then you will know the truth, and the truth will set you free.', 'John 8:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for Your peace to reign in the homes in this region, and that marriages and families would be built on Your Word and Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:13-14', 'prayer-global-porch' ),
                'verse' => _x( 'Bear with each other and forgive one another if any of you has a grievance against someone. Forgive as the Lord forgave you. And over all these virtues put on love, which binds them all together in perfect unity.', 'Colossians 3:13-14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the families in this region, that they would be rooted in Your Word and love one another deeply.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the families in this region, that they would be strong in You and rooted in Your Word.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15b', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15b', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the marriages in this region, that they would be built on the foundation of Your Word and grace.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 19:6', 'prayer-global-porch' ),
                'verse' => _x( 'So they are no longer two, but one flesh. Therefore what God has joined together, let no one separate. Matthew 19:6', 'Matthew 19:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for Your wisdom to be upon the business leaders in this region, that they would make decisions that honor You.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the leaders in this region, that they would seek Your guidance in all their decisions.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray that Your Word would be proclaimed with power and conviction in the churches in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 10:17', 'prayer-global-porch' ),
                'verse' => _x( 'Consequently, faith comes from hearing the message, and the message is heard through the word about Christ.', 'Romans 10:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for a mighty movement of Your Spirit in this region, awakening hearts and drawing people to Your truth.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:14', 'prayer-global-porch' ),
                'verse' => _x( 'Awake, O sleeper, and arise from the dead, and Christ will shine on you.', 'Ephesians 5:14', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_obedience( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Obedience', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, cause the %1$s believers in %2$s to obey with immediate, radical, costly obedience, like Abraham.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => __( 'Genesis 22:2-3', 'prayer-global-porch' ),
                'verse' => _x( 'Then God said, “Take your son, your only son, whom you love — Isaac — and go to the region of Moriah. Sacrifice him there as a burnt offering on a mountain I will show you.” Early the next morning Abraham got up and loaded his donkey. He took with him two of his servants and his son Isaac. When he had cut enough wood for the burnt offering, he set out for the place God had told him about.', 'Genesis 22:2-3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, teach the believers in %1$s of %2$s that love for you and obedience to you are connected.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'John 14:15', 'prayer-global-porch' ),
                'verse' => _x( 'If you love me, keep my commands.', 'John 14:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, remind the disciples in %1$s of %2$s to train each other to obey all that you commanded, and that you will be with them as they do it.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Matthew 28:20', 'prayer-global-porch' ),
                'verse' => _x( 'and teaching them to obey everything I have commanded you. And surely I am with you always, to the very end of the age."', 'Matthew 28:20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, please help the %1$s believers in %2$s of %3$s to be filled with joyful obedience at all times, as you modeled for us all.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, help the %1$s believers in %2$s to know that you can make a big impact through their simple obedience today.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => __( 'Exodus 19:6', 'prayer-global-porch' ),
                'verse' => _x( 'you will be for me a kingdom of priests', 'Exodus 19:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, help the %1$s believers in %2$s to know your commands and to do them.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => __( 'Ezra 7:10', 'prayer-global-porch' ),
                'verse' => _x( 'For Ezra had devoted himself to the study and observance of the Law of the Lord, and to teaching its decrees and laws in Israel.', 'Ezra 7:10', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, raise up a generation of believers in this country that seek to live out Your Word daily.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 119:105', 'prayer-global-porch' ),
                'verse' => _x( 'Your word is a lamp for my feet, a light on my path.', 'Psalm 119:105', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would help the believers in this region to resist temptation and stand firm in their faith.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 10:13', 'prayer-global-porch' ),
                'verse' => _x( 'No temptation has overtaken you except what is common to mankind. And God is faithful; he will not let you be tempted beyond what you can bear. But when you are tempted, he will also provide a way out so that you can endure it.', '1 Corinthians 10:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the youth in this region, that they would be empowered by Your Spirit to live lives of integrity and honor.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for the spirit of reconciliation in this region, that conflicts may be resolved, and peace may prevail.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:9', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are the peacemakers, for they will be called children of God.', 'Matthew 5:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the marriages in this region, that they would reflect the love and sacrifice of Christ, and be strong in faith.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:33', 'prayer-global-porch' ),
                'verse' => _x( 'However, each one of you also must love his wife as he loves himself, and the wife must respect her husband.', 'Ephesians 5:33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, empower the church in this country to shine brightly as a beacon of hope and truth in a dark and broken world.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:8', 'prayer-global-porch' ),
                'verse' => _x( 'For you were once darkness, but now you are light in the Lord. Live as children of light', 'Ephesians 5:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that Your Spirit would move in this region, bringing conviction of sin and a deep desire for repentance.', 'prayer-global-porch' ),
                'reference' => __( 'John 16:8', 'prayer-global-porch' ),
                'verse' => _x( 'When he comes, he will prove the world to be in the wrong about sin and righteousness and judgment:', 'John 16:8', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_reliance_on_god( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Reliance on God', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => __( 'Trust', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Father, move the %1$s believers in %2$s of %3$s to say "Not our will, but yours be done", like Jesus.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Luke 22:41-42', 'prayer-global-porch' ),
                'verse' => _x( 'He withdrew about a stone’s throw beyond them, knelt down and prayed, "Father, if you are willing, take this cup from me; yet not my will, but yours be done."', 'Luke 22:41-42', 'prayer-global-porch' ),
            ],
            [
                'section_label' => __( 'Suffering', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Spirit, please defend the %1$s believers in %2$s against an unwillingness to suffer. Give them courage to face social rejection.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => __( 'Trust', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Please, convict the %1$s believers in %2$s to look to you as their only hope for strength and fruitfulness and life.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'] ),
                'reference' => __( 'John 15:5', 'prayer-global-porch' ),
                'verse' => _x( '"I am the vine; you are the branches. If you remain in me and I in you, you will bear much fruit; apart from me you can do nothing.', 'John 15:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, look after and teach the way that is best for the %1$s believers living in %2$s.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['full_name'] ),
                'reference' => __( 'Psalm 32:8', 'prayer-global-porch' ),
                'verse' => _x( 'I will instruct you and teach you in the way you should go. I will counsel you with my loving eye on you.', 'Psalm 32:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, train the church of %1$s to trust with all their hearts, and you will make their paths straight.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in Yahweh with all your heart, and don’t lean on your own understanding. In all your ways acknowledge him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, remind your church in %1$s that they can know and depend on the love you have for them.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( '1 John 4:16', 'prayer-global-porch' ),
                'verse' => _x( 'We know and have believed the love which God has for us. God is love, and he who remains in love remains in God, and God remains in him.', '1 John 4:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, encourage your church in %1$s that you never forsake them.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( 'Psalm 9:10', 'prayer-global-porch' ),
                'verse' => _x( 'Those who know your name will put their trust in you, for you, Yahweh, have not forsaken those who seek you.', 'Psalm 9:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, reveal your kingdom to those with a childlike heart in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Matthew 11:25-26', 'prayer-global-porch' ),
                'verse' => _x( 'At that time, Jesus answered, “I thank you, Father, Lord of heaven and earth, that you hid these things from the wise and understanding, and revealed them to infants. Yes, Father, for so it was well-pleasing in your sight.', 'Matthew 11:25-26', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, teach the %1$s believers that their old life is dead and their new life is hid with Christ.', 'prayer-global-porch' ), $stack['location']['believers'] ),
                'reference' => __( 'Colossians 3:3', 'prayer-global-porch' ),
                'verse' => _x( 'For you died, and your life is hidden with Christ in God.', 'Colossians 3:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, to the people of %1$s you say, "If you wait for Me, I will work on your behalf."', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( 'Isaiah 64:4', 'prayer-global-porch' ),
                'verse' => _x( 'For from of old men have not heard, nor perceived by the ear, neither has the eye seen a God besides you, who works for him who waits for him.', 'Isaiah 64:4', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the students in this region who are facing academic pressures, that you would give them clarity, wisdom, and peace.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for your guidance in the lives of those leading ministries in this country.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'James 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, help the believers in this country to be patient, knowing that you are at work in their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Galatians 6:9', 'prayer-global-porch' ),
                'verse' => _x( 'Let us not become weary in doing good, for at the proper time we will reap a harvest if we do not give up.', 'Galatians 6:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, strengthen the faith of those in this country who are struggling with doubt and fear.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 9:24', 'prayer-global-porch' ),
                'verse' => _x( 'Lord, I believe; help my unbelief!', 'Mark 9:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are battling fear in this region, that they would trust in your perfect love that casts out fear.', 'prayer-global-porch' ),
                'reference' => __( '1 John 4:18', 'prayer-global-porch' ),
                'verse' => _x( 'There is no fear in love. But perfect love drives out fear.', '1 John 4:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, help every believer to trust in your timing and sovereignty in all things.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 3:5-6', 'prayer-global-porch' ),
                'verse' => _x( 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.', 'Proverbs 3:5-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the people who are struggling with guilt in this region, that they would experience the forgiveness and grace found in You.', 'prayer-global-porch' ),
                'reference' => __( '1 John 1:9', 'prayer-global-porch' ),
                'verse' => _x( 'If we confess our sins, he is faithful and just and will forgive us our sins and purify us from all', '1 John 1:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those in this region who are struggling with sin, that they would find redemption in You.', 'prayer-global-porch' ),
                'reference' => __( '1 John 1:9', 'prayer-global-porch' ),
                'verse' => _x( 'If we confess our sins, he is faithful and just and will forgive us our sins and purify us from all unrighteousness.', '1 John 1:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are struggling with fear in this region, that they would experience Your perfect love that casts out all fear.', 'prayer-global-porch' ),
                'reference' => __( '1 John 4:18', 'prayer-global-porch' ),
                'verse' => _x( 'There is no fear in love. But perfect love drives out fear, because fear has to do with punishment. The one who fears is not made perfect in love.', '1 John 4:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are grieving in this region, that You would comfort them and bring them peace in their sorrow.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 1:3-4', 'prayer-global-porch' ),
                'verse' => _x( 'Praise be to the God and Father of our Lord Jesus Christ, the Father of compassion and the God of all comfort, who comforts us in all our troubles, so that we can comfort those in any trouble with the comfort we ourselves receive from God.', '2 Corinthians 1:3-4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are grieving in this region, that You would comfort them with Your peace that surpasses all understanding.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 1:3-4', 'prayer-global-porch' ),
                'verse' => _x( 'Praise be to the God and Father of our Lord Jesus Christ, the Father of compassion and the God of all comfort, who comforts us in all our troubles, so that we can comfort those in any trouble with the comfort we ourselves receive from God.', '2 Corinthians 1:3-4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your comfort for those grieving in this region, that they may find peace in You and healing for their hearts.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 1:3-4', 'prayer-global-porch' ),
                'verse' => _x( 'Praise be to the God and Father of our Lord Jesus Christ, the Father of compassion and the God of all comfort, who comforts us in all our troubles, so that we can comfort those in any trouble with the comfort we ourselves receive from God.', '2 Corinthians 1:3-4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are grieving the loss of loved ones in this region, that they would find comfort and strength in Your arms.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 1:3-4', 'prayer-global-porch' ),
                'verse' => _x( 'Praise be to the God and Father of our Lord Jesus Christ, the Father of compassion and the God of all comfort, who comforts us in all our troubles, so that we can comfort those in any trouble with the comfort we ourselves receive from God.', '2 Corinthians 1:3-4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are living in fear in this region, that You would replace their fear with faith in You.', 'prayer-global-porch' ),
                'reference' => __( '2 Timothy 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'For the Spirit God gave us does not make us timid, but gives us power, love and self-discipline.', '2 Timothy 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those in this region who are struggling with fear, that You would replace their fear with Your peace.', 'prayer-global-porch' ),
                'reference' => __( '2 Timothy 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'For the Spirit God gave us does not make us timid, but gives us power, love and self-discipline.', '2 Timothy 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for an outpouring of Your love on this region, that the people would experience Your grace in mighty ways.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 5:5', 'prayer-global-porch' ),
                'verse' => _x( 'And hope does not put us to shame, because God’s love has been poured out into our hearts through the Holy Spirit, who has been given to us.', 'Romans 5:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We ask that families in this region would experience harmony, peace, and the strength of Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Joshua 24:15', 'prayer-global-porch' ),
                'verse' => _x( 'But as for me and my household, we will serve the Lord.', 'Joshua 24:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the communities in this region, that they would experience peace and unity through Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:15', 'prayer-global-porch' ),
                'verse' => _x( '', 'Colossians 3:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are struggling with unforgiveness in this region, that they would experience the healing power of Your forgiveness.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:32', 'prayer-global-porch' ),
                'verse' => _x( 'Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.', 'Ephesians 4:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the marriages in this region, that they would be built on Your love and be a testimony of Your faithfulness.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask that You would strengthen marriages in this region, drawing husbands and wives closer to You and to each other.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the marriages in this region, that couples would find strength in You and build their homes on a foundation of love and respect.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:33', 'prayer-global-porch' ),
                'verse' => _x( 'However, each one of you also must love his wife as he loves himself, and the wife must respect her husband.', 'Ephesians 5:33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those whose hearts are hardened in this region, that You would soften them and bring them to a saving knowledge of Jesus Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Ezekiel 36:26', 'prayer-global-porch' ),
                'verse' => _x( 'I will give you a new heart and put a new spirit in you; I will remove from you your heart of stone and give you a heart of flesh.', 'Ezekiel 36:26', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask that You would move mightily in the hearts of those who are hardened to the gospel in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Ezekiel 36:26', 'prayer-global-porch' ),
                'verse' => _x( 'I will give you a new heart and put a new spirit in you; I will remove from you your heart of stone and give you a heart of flesh.', 'Ezekiel 36:26', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the missionaries in this region, that You would strengthen and encourage them as they serve You faithfully.', 'prayer-global-porch' ),
                'reference' => __( 'Galatians 6:9', 'prayer-global-porch' ),
                'verse' => _x( 'Let us not become weary in doing good, for at the proper time we will reap a harvest if we do not give up.', 'Galatians 6:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are burdened with fear in this region, that they would find strength in You and be filled with courage.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 41:10', 'prayer-global-porch' ),
                'verse' => _x( 'So do not fear, for I am with you; do not be dismayed, for I am your God. I will strengthen you and help you; I will uphold you with my righteous right hand.', 'Isaiah 41:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are dealing with fear in this region, that You would fill them with courage and trust in You.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 41:10', 'prayer-global-porch' ),
                'verse' => _x( 'So do not fear, for I am with you; do not be dismayed, for I am your God. I will strengthen you and help you; I will uphold you with my righteous right hand.', 'Isaiah 41:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those struggling with anger in this region, that You would help them to find peace and self-control.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:19', 'prayer-global-porch' ),
                'verse' => _x( 'My dear brothers and sisters, take note of this: Everyone should be quick to listen, slow to speak and slow to become angry.', 'James 1:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those struggling with anger and frustration in this region, that You would help them to find peace in You.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:19-20', 'prayer-global-porch' ),
                'verse' => _x( 'Everyone should be quick to listen, slow to speak and slow to become angry, because human anger does not produce the righteousness that God desires.', 'James 1:19-20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the widows and orphans in this region, that they would experience Your provision, protection, and love.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:27', 'prayer-global-porch' ),
                'verse' => _x( 'Religion that God our Father accepts as pure and faultless is this: to look after orphans and widows in their distress and to keep oneself from being polluted by the world.', 'James 1:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the widows in this region, that they would find Your comfort, provision, and companionship.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:27', 'prayer-global-porch' ),
                'verse' => _x( 'Religion that God our Father accepts as pure and faultless is this: to look after orphans and widows in their distress and to keep oneself from being polluted by the world.', 'James 1:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the sick in this region, that they would experience Your healing touch and find peace in You.', 'prayer-global-porch' ),
                'reference' => __( 'James 5:15', 'prayer-global-porch' ),
                'verse' => _x( 'And the prayer offered in faith will make the sick person well; the Lord will raise them up. If they have sinned, they will be forgiven.', 'James 5:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the sick in this region, that You would heal them and restore them to health, both physically and spiritually.', 'prayer-global-porch' ),
                'reference' => __( 'James 5:15', 'prayer-global-porch' ),
                'verse' => _x( 'And the prayer offered in faith will make the sick person well; the Lord will raise them up. If they have sinned, they will be forgiven.', 'James 5:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those suffering from physical illness in this region, that You would bring healing and restoration to their bodies.', 'prayer-global-porch' ),
                'reference' => __( 'James 5:15', 'prayer-global-porch' ),
                'verse' => _x( 'And the prayer offered in faith will make the sick person well; the Lord will raise them up. If they have sinned, they will be forgiven.', 'James 5:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those who are struggling with a lack of purpose in this region, that they would find their identity in Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 29:11', 'prayer-global-porch' ),
                'verse' => _x( 'For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future.', 'Jeremiah 29:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for those who have lost hope in this region, that they would find joy and purpose in You.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 29:11', 'prayer-global-porch' ),
                'verse' => _x( 'For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future.', 'Jeremiah 29:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are seeking peace in this region, that they would find true peace in You, the Prince of Peace.', 'prayer-global-porch' ),
                'reference' => __( 'John 14:27', 'prayer-global-porch' ),
                'verse' => _x( 'Peace I leave with you; my peace I give you. I do not give to you as the world gives. Do not let your hearts be troubled and do not be afraid.', 'John 14:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for Your peace to rule in the hearts of those in this region, replacing fear with trust in You.', 'prayer-global-porch' ),
                'reference' => __( 'John 14:27', 'prayer-global-porch' ),
                'verse' => _x( 'Peace I leave with you; my peace I give you. I do not give to you as the world gives. Do not let your hearts be troubled and do not be afraid.', 'John 14:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for Your presence to bring peace to the hearts of the anxious and troubled in this region.', 'prayer-global-porch' ),
                'reference' => __( 'John 14:27', 'prayer-global-porch' ),
                'verse' => _x( 'Peace I leave with you; my peace I give you. I do not give to you as the world gives. Do not let your hearts be troubled and do not be afraid.', 'John 14:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for those who are addicted in this region, that they would be set free by the power of Your love and grace.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the incarcerated individuals in this region, that they may experience true freedom in Christ and be transformed with new life and hope.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 4:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Lord is on me, because he has anointed me to proclaim good news to the poor. He has sent me to proclaim freedom for the prisoners and recovery of sight for the blind, to set the oppressed free,', 'Luke 4:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those in this region who are facing challenges in their education, that You would help them to persevere and succeed.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:13', 'prayer-global-porch' ),
                'verse' => _x( 'I can do all this through him who gives me strength.', 'Philippians 4:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for Your supernatural provision to meet the needs of the people in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that Your peace would reign in the hearts of all believers in this region, overcoming fear and anxiety.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those struggling with mental health issues in this region, that they would find healing, peace, and hope in You.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those suffering from mental health issues in this region, that they would experience Your peace that surpasses all understanding.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the healing of physical and emotional wounds in this region, that Your touch would restore all who are hurting.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that Your presence would fill every heart in this region, bringing peace, joy, and a deeper understanding of Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 16:11', 'prayer-global-porch' ),
                'verse' => _x( 'You make known to me the path of life; you will fill me with joy in your presence, with eternal pleasures at your right hand.', 'Psalm 16:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask that You would bring hope to the hopeless in this region, that they would find comfort and strength in You.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 42:11', 'prayer-global-porch' ),
                'verse' => _x( 'Why, my soul, are you downcast? Why so disturbed within me? Put your hope in God, for I will yet praise him, my Savior and my God.', 'Psalm 42:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those who are experiencing spiritual dryness in this region, that You would renew their hearts and revive their spirits.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 51:10', 'prayer-global-porch' ),
                'verse' => _x( 'Create in me a pure heart, O God, and renew a steadfast spirit within me.', 'Psalm 51:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those experiencing spiritual dryness in this region, that they would find renewal and refreshment in Your presence.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 51:12', 'prayer-global-porch' ),
                'verse' => _x( 'Restore to me the joy of your salvation and grant me a willing spirit, to sustain me.', 'Psalm 51:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the single parents in this region, that You would give them strength, wisdom, and peace as they raise their children.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the single parents in this region, that You would give them strength, wisdom, and support as they raise their children.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for Your protection and provision for single mothers in this region, that they may feel Your comfort and support in their daily struggles.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for Your provision and guidance for single parents in this region, that they would have the strength to raise their children with love and care.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the widows and single parents in this region, that they would experience Your comfort and provision.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those struggling with loneliness in this region, that they would experience Your presence and find fellowship in the body of Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:6', 'prayer-global-porch' ),
                'verse' => _x( 'God sets the lonely in families, he leads out the prisoners with singing; but the rebellious live in a sun-scorched land.', 'Psalm 68:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are struggling with loneliness in this region, that they would experience Your presence and find meaningful community.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:6', 'prayer-global-porch' ),
                'verse' => _x( 'God sets the lonely in families, he leads out the prisoners with singing; but the rebellious live in a sun-scorched land.', 'Psalm 68:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for a great awakening in this region, that many would turn to You and receive the gift of eternal life.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 13:11', 'prayer-global-porch' ),
                'verse' => _x( 'And do this, understanding the present time: The hour has already come for you to wake up from your slumber, because our salvation is nearer now than when we first believed.', 'Romans 13:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for a great spiritual awakening in this region, that many would turn to You and find new life in Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 13:11', 'prayer-global-porch' ),
                'verse' => _x( 'And do this, understanding the present time: The hour has already come for you to wake up from your slumber, because our salvation is nearer now than when we first believed.', 'Romans 13:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would grant spiritual awakening to the people in this region, that many would come to know You as Savior.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 13:11', 'prayer-global-porch' ),
                'verse' => _x( 'And do this, understanding the present time: The hour has already come for you to wake up from your slumber, because our salvation is nearer now than when we first believed.', 'Romans 13:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, help this region experience a spiritual awakening, where hearts are turned toward You and lives are transformed.', 'prayer-global-porch' ),
                'reference' => __( 'Zechariah 14:9', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord will be king over the whole earth. On that day there will be one Lord, and his name the only name.', 'Zechariah 14:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for a fresh outpouring of Your Spirit upon the churches in this region, that they would be revived and strengthened in their faith.', 'prayer-global-porch' ),
                'reference' => __( 'Titus 3:5', 'prayer-global-porch' ),
                'verse' => _x( 'He saved us, not because of righteous things we had done, but because of his mercy. He saved us through the washing of rebirth and renewal by the Holy Spirit.', 'Titus 3:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, bring revival to this country, transforming hearts and communities for Your glory.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 85:6', 'prayer-global-porch' ),
                'verse' => _x( 'Will you not revive us again, that your people may rejoice in you?', 'Psalm 85:6', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_faithfulness( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Prayer Movement', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => __( 'Faith', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Spirit, teach the %1$s believers in %2$s that when they seek first your Kingdom and your righteousness, you will abundantly provide all they need.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => __( '2 Corinthians 9:8', 'prayer-global-porch' ),
                'verse' => _x( 'And God is able to bless you abundantly, so that in all things at all times, having all that you need, you will abound in every good work.', '2 Corinthians 9:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => __( 'Faith', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Lord, please give the %1$s believers in %2$s of %3$s the Spirit of wisdom and revelation, so that they might know you better.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Ephesians 1:17', 'prayer-global-porch' ),
                'verse' => _x( 'I keep asking that the God of our Lord Jesus Christ, the glorious Father, may give you the Spirit of wisdom and revelation, so that you may know him better.', 'Ephesians 1:17', 'prayer-global-porch' ),
            ],

            [
                'section_label' => __( 'Faith', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Spirit, please defend the %1$s believers in %2$s against self-centered spirituality. Open their eyes to the fields ripe for harvest around them.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => __( 'Faithfulness', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Father, convict the %1$s believers in %2$s to be holy and righteous. Inspire them to gather in small groups for accountability and spiritual growth.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => __( 'Faithfulness', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Lord, we know that you invest more in those who have been faithful with what they have been given. Please, richly bless each faithful believer in %1$s with more spiritual insight, wisdom, courage and vision.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => __( 'Matthew 25:28-29', 'prayer-global-porch' ),
                'verse' => _x( 'So take the bag of gold from him and give it to the one who has ten bags. For whoever has will be given more, and they will have an abundance. Whoever does not have, even what they have will be taken from them.', 'Matthew 25:28-29', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, please reward those who diligently seek you with a heart of faith in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Hebrews 11:6', 'prayer-global-porch' ),
                'verse' => _x( 'Without faith it is impossible to be well pleasing to him, for he who comes to God must believe that he exists, and that he is a rewarder of those who seek him.', 'Hebrews 11:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, sanctify the %1$s believers in %2$s and keep them blameless until Jesus returns.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => __( '1 Thessalonians 5:23-24', 'prayer-global-porch' ),
                'verse' => _x( 'May the God of peace himself sanctify you completely. May your whole spirit, soul, and body be preserved blameless at the coming of our Lord Jesus Christ. He who calls you is faithful, who will also do it.', '1 Thessalonians 5:23-24', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for marriages in this region, that couples would reflect your love and commitment to one another.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her.', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for marriages in this region. May couples be committed to loving and serving each other, reflecting Christ\'s love for the Church.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her.', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that you would bless the marriages in this region, strengthening the bond between husbands and wives.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her.', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the persecuted believers in this region, that they would remain faithful and strong in their commitment to you.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:13', 'prayer-global-porch' ),
                'verse' => _x( 'I can do all this through him who gives me strength.', 'Philippians 4:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that the Church in this region would not grow weary in doing good, but continue to serve others in your name.', 'prayer-global-porch' ),
                'reference' => __( 'Galatians 6:9', 'prayer-global-porch' ),
                'verse' => _x( 'Let us not become weary in doing good, for at the proper time we will reap a harvest if we do not give up.', 'Galatians 6:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, give the believers in this country a bold faith that does not shrink back in the face of adversity.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 28:1', 'prayer-global-porch' ),
                'verse' => _x( 'The wicked flee though no one pursues, but the righteous are as bold as a lion.', 'Proverbs 28:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the believers in this region grow in boldness and confidence to share their faith with others.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 28:1', 'prayer-global-porch' ),
                'verse' => _x( 'The wicked flee though no one pursues, but the righteous are as bold as a lion.', 'Proverbs 28:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the marriages in this region, that they would be strong, faithful, and a reflection of your love.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 10:9', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore what God has joined together, let no one separate.', 'Mark 10:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray that marriages in this region would be strong, faithful, and a reflection of your love for the Church.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 10:9', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore what God has joined together, let no one separate.', 'Mark 10:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, let your love and grace abound in the lives of believers in this country, so that through them, the lost may encounter your saving truth.', 'prayer-global-porch' ),
                'reference' => __( '1 John 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'We love because he first loved us.', '1 John 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those facing persecution in this region for their faith, that they would remain steadfast and courageous.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness, for theirs is the kingdom of heaven.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are persecuted for their faith in this region, that they may remain strong and faithful.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness, for theirs is the kingdom of heaven.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, help the believers in this region to be good stewards of the resources You have given them, using them to bless others.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 4:10', 'prayer-global-porch' ),
                'verse' => _x( 'Each of you should use whatever gift you have received to serve others, as faithful stewards of God’s grace in its various forms.', '1 Peter 4:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would give Your Church in this region the strength to endure trials and remain faithful.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 12:12', 'prayer-global-porch' ),
                'verse' => _x( 'Be joyful in hope, patient in affliction, faithful in prayer.', 'Romans 12:12', 'prayer-global-porch' ),
            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( 'Hebrews 11:6', 'prayer-global-porch' ),
//                'verse' => _x( 'And without faith, it is impossible to please Him, for he who comes to God must believe that He is and that He is a rewarder of those who seek Him.', 'Hebrews 11:6', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( 'Lamentations 3:25', 'prayer-global-porch' ),
//                'verse' => _x( 'The LORD is good to them that wait for him, to the soul that seeks him.', 'Lamentations 3:25', 'prayer-global-porch' ),
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => __( 'Psalm 119:2', 'prayer-global-porch' ),
//                'verse' => _x( 'How blessed are those who observe His testimonies, who seek Him with all their heart?', 'Psalm 119:2', 'prayer-global-porch' ),
//            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_suffering( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Suffering', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, let those from the %1$s believers who are shaken and weak remember that your love will never fail them.', 'prayer-global-porch' ), $stack['location']['believers'] ),
                'reference' => __( '1 Corinthians 13:8', 'prayer-global-porch' ),
                'verse' => _x( 'Love never fails. But where there are prophecies, they will be done away with. Where there are various languages, they will cease. Where there is knowledge, it will be done away with.', '1 Corinthians 13:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, put the people who are lonely into families in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 68:6', 'prayer-global-porch' ),
                'verse' => _x( 'God sets the lonely in families. He brings out the prisoners with singing, but the rebellious dwell in a sun-scorched land.', 'Psalm 68:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, protect the overcomers in %1$s, so that they will one day sit with Jesus on His throne.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Revelation 3:21', 'prayer-global-porch' ),
                'verse' => _x( 'He who overcomes, I will give to him to sit down with me on my throne, as I also overcame, and sat down with my Father on his throne.', 'Revelation 3:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, you have chosen the weak things of this world to confound the strong. Make the poor and outcast in %1$s of %2$s a testimony of your strength.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( '1 Corinthians 1:27', 'prayer-global-porch' ),
                'verse' => _x( 'God chose the foolish things of the world that he might put to shame those who are wise. God chose the weak things of the world, that he might put to shame the things that are strong;', '1 Corinthians 1:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, encourage the church of %1$s that they are blessed with every heavenly blessing.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Ephesians 1:3', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed be the God and Father of our Lord Jesus Christ, who has blessed us with every spiritual blessing in the heavenly places in Christ', 'Ephesians 1:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, thank you that you will never abandon the church of %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Hebrews 13:5 ', 'prayer-global-porch' ),
                'verse' => _x( 'Be free from the love of money, content with such things as you have, for he has said, “I will in no way leave you, neither will I in any way forsake you.', 'Hebrews 13:5 ', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, for those distressed and afraid in %1$s, show them today that you give peace at all times and in every situation.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( '2 Thessalonians 3:16', 'prayer-global-porch' ),
                'verse' => _x( 'Now may the Lord of peace himself give you peace at all times in all ways. The Lord be with you all.', '2 Thessalonians 3:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, please find the broken hearted among the %1$s souls in %2$s and mend their wounds.', 'prayer-global-porch' ), $stack['location']['population'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, comfort those who mourn in %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, see the suffering of your people in %1$s of %2$s. Deliver all those who have not forgotten your Word.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Psalm 119:153', 'prayer-global-porch' ),
                'verse' => _x( 'Look on my suffering and deliver me, for I have not forgotten your law.', 'Psalm 119:153', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those suffering from mental illness in this region, that they may find peace and healing in you.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 5:7', 'prayer-global-porch' ),
                'verse' => _x( 'Cast all your anxiety on him because he cares for you.', '1 Peter 5:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for your healing hand to be upon the sick and those with physical ailments in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for healing in this region—emotionally, spiritually, and physically—for those suffering from pain and trauma.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for your healing touch on the sick and hurting in this country.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for your healing touch to be upon those suffering from illness in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for families in this region that are broken or struggling, that they may experience healing and restoration in you.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the health system in this region, that it would bring healing to the sick and be a place of compassion.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the sick in this region, that you would heal them and restore them to health by your power.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May the health system in this region bring healing to the sick and reflect your compassion and grace.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We ask for your healing touch on the sick in this region, that they may experience restoration and strength.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the sick in this region, that you would bring healing to their bodies and comfort to their hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those caught in poverty in this region, that they may find hope and provision in you.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 37:25', 'prayer-global-porch' ),
                'verse' => _x( 'I was young and now I am old, yet I have never seen the righteous forsaken or their children begging bread.', 'Psalm 37:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'May those living in poverty in this region find provision and hope through your abundant grace.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 37:25', 'prayer-global-porch' ),
                'verse' => _x( 'I was young and now I am old, yet I have never seen the righteous forsaken or their children begging bread.', 'Psalm 37:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are imprisoned in this region, that they may experience your freedom in their hearts.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'If the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may those living in fear in this region experience the peace that only comes from you.', 'prayer-global-porch' ),
                'reference' => __( 'John 14:27', 'prayer-global-porch' ),
                'verse' => _x( 'Peace I leave with you; my peace I give you. I do not give to you as the world gives. Do not let your hearts be troubled and do not be afraid.', 'John 14:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those suffering from addiction in this region, that they may find freedom and healing in you.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are incarcerated in this region, that they would find freedom in Christ and experience your love.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those suffering from addictions in this region, that they would experience deliverance and new life in Christ.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that you would bring healing to those struggling with addiction in this country.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those struggling with addiction in this region, that they would find freedom and healing through your power.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray that those who are suffering from addiction in this region may find freedom in you.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the mental health professionals in this region, that they would be filled with wisdom and compassion to serve those in need.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those struggling with depression in this region, that they would find peace and healing in your presence.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'For those struggling with mental health in this region, we ask for peace and healing through your Spirit.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those experiencing natural disasters in this region, that they may experience your presence in the midst of their suffering.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for the victims of natural disasters in this region, that they would sense your comforting presence amid their trials.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those caught in human trafficking in this region, that you would bring freedom and restoration to their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 27:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is my light and my salvation—whom shall I fear?', 'Psalm 27:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those in this country who are financially struggling, that you would provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 23:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is my shepherd, I lack nothing.', 'Psalm 23:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for your provision to meet the needs of the poor and marginalized in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 23:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is my shepherd, I lack nothing.', 'Psalm 23:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for the provision of work opportunities in this region, especially for those struggling with unemployment.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 23:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is my shepherd, I lack nothing.', 'Psalm 23:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are lonely in this region, that they may experience your presence and find true community in you.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those in prison in this region, that they would encounter your love and find hope and freedom in Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 146:7', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord sets prisoners free.', 'Psalm 146:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that you would heal broken relationships in this region, restoring marriages and families to reflect your love.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 10:9', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore what God has joined together, let no one separate.', 'Mark 10:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those dealing with substance abuse in this region, that You would free them from addiction and renew their hearts.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 10:13', 'prayer-global-porch' ),
                'verse' => _x( 'No temptation has overtaken you except what is common to mankind. And God is faithful; he will not let you be tempted beyond what you can bear. But when you are tempted, he will also provide a way out so that you can endure it.', '1 Corinthians 10:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the people who are facing addiction to pornography in this region, that You would heal them and restore their purity.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 10:13', 'prayer-global-porch' ),
                'verse' => _x( 'No temptation has overtaken you except what is common to mankind. And God is faithful; he will not let you be tempted beyond what you can bear. But when you are tempted, he will also provide a way out so that you can endure it.', '1 Corinthians 10:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those who are struggling with addiction to pornography in this region, that You would break the chains and bring healing and purity.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 10:13', 'prayer-global-porch' ),
                'verse' => _x( 'No temptation has overtaken you except what is common to mankind. And God is faithful; he will not let you be tempted beyond what you can bear. But when you are tempted, he will also provide a way out so that you can endure it.', '1 Corinthians 10:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the people in this region who are struggling with addiction to gambling, that You would bring deliverance and freedom.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 6:12', 'prayer-global-porch' ),
                'verse' => _x( 'I have the right to do anything, you say— but not everything is beneficial. I have the right to do anything— but I will not be mastered by anything.', '1 Corinthians 6:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we lift up the widows in this region, asking that You comfort them, surround them with Your peace, and meet every one of their needs.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 5:3', 'prayer-global-porch' ),
                'verse' => _x( 'Give proper recognition to those widows who are really in need.', '1 Timothy 5:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those experiencing the loss of a loved one in this region, that You would comfort them with Your peace and love.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 1:3-4', 'prayer-global-porch' ),
                'verse' => _x( 'Praise be to the God and Father of our Lord Jesus Christ, the Father of compassion and the God of all comfort, who comforts us in all our troubles, so that we can comfort those in any trouble with the comfort we ourselves receive from God.', '2 Corinthians 1:3-4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those struggling with chronic pain in this region, that You would provide relief and strength for each day.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 12:9', 'prayer-global-porch' ),
                'verse' => _x( 'But he said to me, ‘My grace is sufficient for you, for my power is made perfect in weakness.’ Therefore I will boast all the more gladly of my weaknesses, so that the power of Christ may rest upon me.', '2 Corinthians 12:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those in this region who are struggling with addiction, that You would break the chains and set them free.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 5:17', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore, if anyone is in Christ, the new creation has come:The old has gone, the new is here!', '2 Corinthians 5:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those battling addiction in this region, that You would bring them into freedom and healing.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 5:17', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore, if anyone is in Christ, the new creation has come:The old has gone, the new is here!', '2 Corinthians 5:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those with broken relationships in this region, that You would bring reconciliation and healing.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 5:18', 'prayer-global-porch' ),
                'verse' => _x( 'All this is from God, who reconciled us to himself through Christ and gave us the ministry of reconciliation:', '2 Corinthians 5:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that Your love would spread throughout this region, bringing reconciliation and healing to broken relationships.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 5:18', 'prayer-global-porch' ),
                'verse' => _x( 'All this is from God, who reconciled us to himself through Christ and gave us the ministry of reconciliation:', '2 Corinthians 5:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are struggling with broken relationships in this region, that You would bring reconciliation and healing.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 5:18', 'prayer-global-porch' ),
                'verse' => _x( 'All this is from God, who reconciled us to himself through Christ and gave us the ministry of reconciliation:', '2 Corinthians 5:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask that You would heal broken relationships in this region, restoring trust and reconciliation between individuals and communities.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 5:18', 'prayer-global-porch' ),
                'verse' => _x( 'All this is from God, who reconciled us to himself through Christ and gave us the ministry of reconciliation:', '2 Corinthians 5:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for Your provision for those in need in this country, that they may experience Your care.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the health workers in this region, that You would strengthen them and provide for their needs during this challenging time.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those facing unemployment in this region, that You would provide for them according to Your riches in glory.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray that those in this region who are experiencing economic hardship would receive provision and hope.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are struggling with financial hardship in this region. May they trust You to provide for their every need.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your provision for the people in this region who are in need. May they see Your faithfulness in providing for them.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'For those persecuted in this region for their faith, we ask that they remain steadfast, filled with courage and hope.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:10', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who are persecuted because of righteousness, for theirs is the kingdom of heaven.', 'Matthew 5:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those grieving in this region, that You would bring comfort and healing to their broken hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your comfort for those mourning in this region, that they would experience Your peace in their grief.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those in this region who are grieving, that they may find comfort and hope in You.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are grieving in this region, that they may find comfort in Your embrace.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'We pray for those grieving in this region, that Your comfort would surround them and bring peace to their hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You comfort those who are mourning in this region, bringing peace and hope in their grief.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that Your presence would bring peace to the troubled hearts of those suffering from anxiety in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.', 'Philippians 4:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for Your peace to reign in the hearts of those struggling with fear and anxiety in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.', 'Philippians 4:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, let Your peace reign in the hearts of those in this country who are struggling with anxiety and fear.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.', 'Philippians 4:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are struggling with fear and anxiety in this region. May they experience Your peace that surpasses all understanding.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.', 'Philippians 4:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those struggling with low self-esteem in this region, that they would know they are beloved and created in Your image.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 2:10', 'prayer-global-porch' ),
                'verse' => _x( 'For we are God’s handiwork, created in Christ Jesus to do good works, which God prepared in advance for us to do.', 'Ephesians 2:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the immigrants in this region, that You would help them find a place of belonging and support.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 2:19', 'prayer-global-porch' ),
                'verse' => _x( 'Consequently, you are no longer foreigners and strangers, but fellow citizens with God’s people and also members of his household.', 'Ephesians 2:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for peace and reconciliation in areas of conflict within this region, that Your love would bring healing and unity.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the families who are struggling with division in this region, that You would heal relationships and restore unity.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would heal the broken relationships in this region, and restore unity and peace among families and communities.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:32', 'prayer-global-porch' ),
                'verse' => _x( 'Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.', 'Ephesians 4:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the healing of broken relationships in this region, that Your love would restore what has been fractured.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:32', 'prayer-global-porch' ),
                'verse' => _x( 'Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.', 'Ephesians 4:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the broken families in this region, that You would bring healing and reconciliation where there is division.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:32', 'prayer-global-porch' ),
                'verse' => _x( 'Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.', 'Ephesians 4:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the people in this region who are battling addiction to alcohol, that You would deliver them and restore their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:18', 'prayer-global-porch' ),
                'verse' => _x( 'Do not get drunk on wine, which leads to debauchery. Instead, be filled with the Spirit.', 'Ephesians 5:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those facing injustice in this region, that You would intervene and bring about a restoration of righteousness.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 1:17', 'prayer-global-porch' ),
                'verse' => _x( 'Learn to do right; seek justice. Defend the oppressed. Take up the cause of the fatherless; plead the case of the widow.', 'Isaiah 1:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are suffering from mental health challenges in this region, that they may experience Your peace and healing.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 26:3', 'prayer-global-porch' ),
                'verse' => _x( 'You will keep in perfect peace those whose minds are steadfast, because they trust in you.', 'Isaiah 26:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the mentally ill in this region, that You would bring healing to their minds and peace to their hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 26:3', 'prayer-global-porch' ),
                'verse' => _x( 'You will keep in perfect peace those whose minds are steadfast, because they trust in you.', 'Isaiah 26:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those battling with physical ailments in this region, that You would bring healing and strength.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 53:5', 'prayer-global-porch' ),
                'verse' => _x( 'But he was pierced for our transgressions, he was crushed for our iniquities; the punishment that brought us peace was on him, and by his wounds we are healed.', 'Isaiah 53:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask for Your healing to touch the sick in this region, restoring their bodies and spirits.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 53:5', 'prayer-global-porch' ),
                'verse' => _x( 'But he was pierced for our transgressions, he was crushed for our iniquities; the punishment that brought us peace was on him, and by his wounds we are healed.', 'Isaiah 53:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for healing for those in this region who are suffering from physical illnesses, that they may experience Your restoration.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 53:5', 'prayer-global-porch' ),
                'verse' => _x( 'But he was pierced for our transgressions, he was crushed for our iniquities; the punishment that brought us peace was on him, and by his wounds we are healed.', 'Isaiah 53:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the sick in this region, that Your healing touch would restore them and bring them peace.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 53:5', 'prayer-global-porch' ),
                'verse' => _x( 'But he was pierced for our transgressions, he was crushed for our iniquities; the punishment that brought us peace was on him, and by his wounds we are healed.', 'Isaiah 53:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we lift up those facing poverty in this region. May You meet their every need and restore their dignity with Your love and provision.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 58:10', 'prayer-global-porch' ),
                'verse' => _x( 'If you pour yourselves out for the hungry and satisfy the desire of the afflicted, then shall your light rise in the darkness and your gloom be as the noonday.', 'Isaiah 58:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the victims of human trafficking in this region, that You would bring them freedom and restoration.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 58:6', 'prayer-global-porch' ),
                'verse' => _x( 'Is not this the kind of fasting I have chosen: to loose the chains of injustice and untie the cords of the yoke, to set the oppressed free and break every yoke?', 'Isaiah 58:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the prisoners in this region, that they would experience Your grace and redemption.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 61:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Sovereign Lord is on me, because the Lord has anointed me to proclaim good news to the poor. He has sent me to bind up the brokenhearted, to proclaim freedom for the captives and release from darkness for the prisoners,', 'Isaiah 61:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would heal the brokenhearted in this region and set the captives free.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 61:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Sovereign Lord is on me, because the Lord has anointed me to proclaim good news to the poor. He has sent me to bind up the brokenhearted, to proclaim freedom for the captives and release from darkness for the prisoners,', 'Isaiah 61:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the prisoners in this region, that they would find freedom in Christ and be restored to new life.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 61:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Sovereign Lord is on me, because the Lord has anointed me to proclaim good news to the poor. He has sent me to bind up the brokenhearted, to proclaim freedom for the captives and release from darkness for the prisoners,', 'Isaiah 61:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those in this region suffering from oppression, that You would bring justice, freedom, and deliverance.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 61:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Sovereign Lord is on me, because the Lord has anointed me to proclaim good news to the poor. He has sent me to bind up the brokenhearted, to proclaim freedom for the captives and release from darkness for the prisoners,', 'Isaiah 61:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the marginalized in this region, that they would know they are deeply loved by You and find hope in Your embrace.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 61:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Sovereign Lord is on me, because the Lord has anointed me to proclaim good news to the poor. He has sent me to bind up the brokenhearted, to proclaim freedom for the captives and release from darkness for the prisoners,', 'Isaiah 61:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the people in this region who are trapped in cycles of poverty, that You would break the chains and provide opportunities for them to thrive.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 61:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Sovereign Lord is on me, because the Lord has anointed me to proclaim good news to the poor. He has sent me to bind up the brokenhearted, to proclaim freedom for the captives and release from darkness for the prisoners,', 'Isaiah 61:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for those who are struggling with addiction in this region, that they may find freedom and healing through Your grace.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 61:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Sovereign Lord is on me, because the Lord has anointed me to proclaim good news to the poor. He has sent me to bind up the brokenhearted, to proclaim freedom for the captives and release from darkness for the prisoners,', 'Isaiah 61:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the widows in this region, that You would comfort them and provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:27', 'prayer-global-porch' ),
                'verse' => _x( 'Religion that God our Father accepts as pure and faultless is this: to look after orphans and widows in their distress and to keep oneself from being polluted by the world.', 'James 1:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the orphans in this region, that You would provide for their needs and surround them with love and care.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:27', 'prayer-global-porch' ),
                'verse' => _x( 'Religion that God our Father accepts as pure and faultless is this: to look after orphans and widows in their distress and to keep oneself from being polluted by the world.', 'James 1:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the orphans in this region, that You would provide loving homes and families to care for them.', 'prayer-global-porch' ),
                'reference' => __( 'James 1:27', 'prayer-global-porch' ),
                'verse' => _x( 'Religion that God our Father accepts as pure and faultless is this: to look after orphans and widows in their distress and to keep oneself from being polluted by the world.', 'James 1:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those facing discrimination in this region, that You would bring about equality, justice, and peace.', 'prayer-global-porch' ),
                'reference' => __( 'James 2:1', 'prayer-global-porch' ),
                'verse' => _x( 'My brothers and sisters, believers in our glorious Lord Jesus Christ must not show favoritism.', 'James 2:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those facing discrimination in this region, that You would bring justice and equality for all people.', 'prayer-global-porch' ),
                'reference' => __( 'James 2:1', 'prayer-global-porch' ),
                'verse' => _x( 'My brothers and sisters, believers in our glorious Lord Jesus Christ must not show favoritism.', 'James 2:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those experiencing poverty in this region, that You would provide for their needs and restore their dignity.', 'prayer-global-porch' ),
                'reference' => __( 'James 2:15-16', 'prayer-global-porch' ),
                'verse' => _x( 'Suppose a brother or a sister is without clothes and daily food. If one of you says to them, ‘Go in peace; keep warm and well fed,’ but does nothing about their physical needs, what good is it?', 'James 2:15-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the teachers in this region, that they would be compassionate, guiding students with wisdom and truth.', 'prayer-global-porch' ),
                'reference' => __( 'James 3:17', 'prayer-global-porch' ),
                'verse' => _x( 'But the wisdom that comes from heaven is first of all pure; then peace-loving, considerate, submissive, full of mercy and good fruit, impartial and sincere.', 'James 3:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the sick in this region, that You would heal their bodies and give them strength.', 'prayer-global-porch' ),
                'reference' => __( 'James 5:14-15', 'prayer-global-porch' ),
                'verse' => _x( 'Is anyone among you sick? Let them call the elders of the church to pray over them and anoint them with oil in the name of the Lord. And the prayer offered in faith will make the sick person well; the Lord will raise them up.', 'James 5:14-15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those suffering from chronic illnesses in this region, that You would grant them strength and healing.', 'prayer-global-porch' ),
                'reference' => __( 'James 5:14-15', 'prayer-global-porch' ),
                'verse' => _x( 'Is anyone among you sick? Let them call the elders of the church to pray over them and anoint them with oil in the name of the Lord. And the prayer offered in faith will make the sick person well; the Lord will raise them up.', 'James 5:14-15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the sick in this region, that You would bring healing to their bodies and strength to their spirits.', 'prayer-global-porch' ),
                'reference' => __( 'James 5:14-15', 'prayer-global-porch' ),
                'verse' => _x( 'Is anyone among you sick? Let them call the elders of the church to pray over them and anoint them with oil in the name of the Lord. And the prayer offered in faith will make the sick person well; the Lord will raise them up.', 'James 5:14-15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the sick and the suffering in this region, that You would bring them healing and restore them to full health.', 'prayer-global-porch' ),
                'reference' => __( 'James 5:15', 'prayer-global-porch' ),
                'verse' => _x( 'And the prayer offered in faith will make the sick person well; the Lord will raise them up. If they have sinned, they will be forgiven.', 'James 5:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the workers in this region who face injustice or exploitation, that You would bring them justice and fair treatment.', 'prayer-global-porch' ),
                'reference' => __( 'James 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Look! The wages you failed to pay the workers who mowed your fields are crying out against you. The cries of the harvesters have reached the ears of the Lord Almighty.', 'James 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that Your healing touch would rest upon those suffering from physical ailments in this region, that they would be restored to full health.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 30:17a', 'prayer-global-porch' ),
                'verse' => _x( 'But I will restore you to health and heal your wounds,’ declares the Lord,', 'Jeremiah 30:17a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the sick in this region, that You would bring healing to their bodies, minds, and spirits.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 30:17a', 'prayer-global-porch' ),
                'verse' => _x( 'But I will restore you to health and heal your wounds,’ declares the Lord,', 'Jeremiah 30:17a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those struggling with addiction in this region, that they would find freedom and healing in You.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the people of this region suffering from addiction, that You would free them from the bondage and heal their hearts.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would break the chains of addiction in this region, setting the captives free.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those struggling with addiction in this region, that You would set them free and restore their lives.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those trapped in cycles of addiction in this region, that they would be set free by Your power and grace.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for Your healing and restoration for those suffering from addiction in this region.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the addicts in this region, that You would break the chains of addiction and set them free.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those who are struggling with addiction in this region, that they would find freedom in Christ and be set free.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the people in this region who are experiencing addiction, that they would be set free by Your power and love.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those struggling with addiction in this region, that You would set them free and restore their lives.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask that You would help those struggling with addiction in this region find true freedom in You.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those struggling with substance abuse in this region, that You would break the chains of addiction and bring healing.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:36', 'prayer-global-porch' ),
                'verse' => _x( 'So if the Son sets you free, you will be free indeed.', 'John 8:36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the immigrants in this region, that they would be welcomed and find peace and hope in their new surroundings.', 'prayer-global-porch' ),
                'reference' => __( 'Leviticus 19:34', 'prayer-global-porch' ),
                'verse' => _x( 'The foreigner residing among you must be treated as your native-born. Love them as yourself, for you were foreigners in Egypt. I am the Lord your God.', 'Leviticus 19:34', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the immigrants in this region, that You would provide them with the resources they need and help them to find community.', 'prayer-global-porch' ),
                'reference' => __( 'Leviticus 19:34', 'prayer-global-porch' ),
                'verse' => _x( 'The foreigner residing among you must be treated as your native-born. Love them as yourself, for you were foreigners in Egypt. I am the Lord your God.', 'Leviticus 19:34', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the immigrants and refugees in this region, that they would find safety, belonging, and opportunity in their new communities.', 'prayer-global-porch' ),
                'reference' => __( 'Leviticus 19:34', 'prayer-global-porch' ),
                'verse' => _x( 'The foreigner residing among you must be treated as your native-born. Love them as yourself, for you were foreigners in Egypt. I am the Lord your God.', 'Leviticus 19:34', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the disabled in this region, that they would receive the care, dignity, and respect they deserve.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 14:13-14', 'prayer-global-porch' ),
                'verse' => _x( 'But when you give a banquet, invite the poor, the crippled, the lame, the blind, and you will be blessed. Although they cannot repay you, you will be repaid at the resurrection of the righteous.', 'Luke 14:13-14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those who are oppressed in this region, that You would bring freedom and justice to their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 4:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Lord is on me, because he has anointed me to proclaim good news to the poor. He has sent me to proclaim freedom for the prisoners and recovery of sight for the blind, to set the oppressed free,', 'Luke 4:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would bring healing and restoration to those suffering from broken families in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Malachi 4:6', 'prayer-global-porch' ),
                'verse' => _x( 'He will turn the hearts of the parents to their children, and the hearts of the children to their parents…', 'Malachi 4:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would bring healing to the broken families in this region, restoring relationships and bringing Your peace.', 'prayer-global-porch' ),
                'reference' => __( 'Malachi 4:6', 'prayer-global-porch' ),
                'verse' => _x( 'He will turn the hearts of the parents to their children, and the hearts of the children to their parents…', 'Malachi 4:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those who are struggling with depression and anxiety in this region, that they would find peace in Your presence.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 11:28-29', 'prayer-global-porch' ),
                'verse' => _x( 'Come to me, all you who are weary and burdened, and I will give you rest. Take my yoke upon you and learn from me, for I am gentle and humble in heart, and you will find rest for your souls.', 'Matthew 11:28-29', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the homeless in this region, that You would provide them with shelter and hope for a brighter future.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:35', 'prayer-global-porch' ),
                'verse' => _x( 'For I was hungry and you gave me something to eat, I was thirsty and you gave me something to drink, I was a stranger and you invited me in,', 'Matthew 25:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the homeless in this region, that You would provide shelter, food, and hope, and meet their every need.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:35', 'prayer-global-porch' ),
                'verse' => _x( 'For I was hungry and you gave me something to eat, I was thirsty and you gave me something to drink, I was a stranger and you invited me in,', 'Matthew 25:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the homeless in this region, that You would provide shelter, food, and warmth, and that they would experience Your love and grace.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:35', 'prayer-global-porch' ),
                'verse' => _x( 'For I was hungry and you gave me something to eat, I was thirsty and you gave me something to drink, I was a stranger and you invited me in,', 'Matthew 25:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the homeless in this region, that You would provide shelter and restore their dignity.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:35-36', 'prayer-global-porch' ),
                'verse' => _x( 'For I was hungry and you gave me something to eat, I was thirsty and you gave me something to drink, I was a stranger and you invited me in, I needed clothes and you clothed me, I was sick and you looked after me, I was in prison and you came to visit me.’', 'Matthew 25:35-36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are living in poverty in this region, that You would provide for their needs and raise up those who will help them.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:35-36', 'prayer-global-porch' ),
                'verse' => _x( 'For I was hungry and you gave me something to eat, I was thirsty and you gave me something to drink, I was a stranger and you invited me in, I needed clothes and you clothed me, I was sick and you looked after me, I was in prison and you came to visit me.’', 'Matthew 25:35-36', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those who are grieving in this region, that You would comfort them with Your presence.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for Your comfort and peace for those who are mourning in this region, that they may find solace in Your loving arms.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would provide comfort for those who have lost loved ones in this region, and may they experience Your peace.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are working through grief in this region, that You would comfort them and bring them healing and peace.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask that You would bring comfort to those who are mourning in this region, that they would feel Your presence in their grief.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those who are grieving in this region, that they would experience Your comfort and healing presence.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for Your comfort and strength for those who are mourning the loss of loved ones in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 5:4', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who mourn, for they will be comforted.', 'Matthew 5:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the people in this region who are facing addictions to technology, that You would help them find balance and focus on what truly matters.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:21', 'prayer-global-porch' ),
                'verse' => _x( 'For where your treasure is, there your heart will be also.', 'Matthew 6:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the people who are dealing with addiction to gambling in this region, that You would break their chains and restore their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:24', 'prayer-global-porch' ),
                'verse' => _x( 'No one can serve two masters. Either you will hate the one and love the other, or you will be devoted to the one and despise the other.', 'Matthew 6:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those suffering from financial strain in this region, that You would provide for their needs and give them peace of mind.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:31-33', 'prayer-global-porch' ),
                'verse' => _x( 'So do not worry, saying, ‘What shall we eat?’ or ‘What shall we drink?’ or ‘What shall we wear?’ For the pagans run after all these things, and your heavenly Father knows that you need them. But seek first his kingdom and his righteousness, and all these things will be given to you as well.', 'Matthew 6:31-33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask that You would provide for the physical needs of those who are struggling in this region, showing them Your faithfulness.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:31-33', 'prayer-global-porch' ),
                'verse' => _x( 'So do not worry, saying, ‘What shall we eat?’ or ‘What shall we drink?’ or ‘What shall we wear?’ For the pagans run after all these things, and your heavenly Father knows that you need them. But seek first his kingdom and his righteousness, and all these things will be given to you as well.', 'Matthew 6:31-33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for families in this region that are struggling financially, that You would provide for them in abundance.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:31-33', 'prayer-global-porch' ),
                'verse' => _x( 'So do not worry, saying, ‘What shall we eat?’ or ‘What shall we drink?’ or ‘What shall we wear?’ For the pagans run after all these things, and your heavenly Father knows that you need them. But seek first his kingdom and his righteousness, and all these things will be given to you as well.', 'Matthew 6:31-33', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the people in this region who are struggling with chronic stress, that You would grant them peace and rest.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:34', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore do not worry about tomorrow, for tomorrow will worry about itself. Each day has enough trouble of its own.', 'Matthew 6:34', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those suffering from depression in this region, that You would restore their joy and bring them peace in You.', 'prayer-global-porch' ),
                'reference' => __( 'Nehemiah 8:10', 'prayer-global-porch' ),
                'verse' => _x( 'Do not grieve, for the joy of the Lord is your strength.', 'Nehemiah 8:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the unemployed in this region, that You would provide new opportunities and hope for the future.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those battling financial difficulties in this region, that You would provide for their needs and guide them to financial stability.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the people of this region who are facing financial difficulties, that You would provide for them according to Your riches in glory.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for Your provision for the unemployed in this region, that You would open doors of opportunity and provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'Philippians 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those in this region struggling with anxiety, that You would provide peace and comfort to their hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we lift up those in this region who are battling anxiety, asking that You fill their hearts with Your peace and bring them comfort', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those struggling with mental health in this region, that You would surround them with peace, comfort, and support.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are suffering from anxiety in this region, that they would cast all their cares on You.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those struggling with fear and anxiety in this region, that Your peace would guard their hearts and minds.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for peace to reign in the hearts of those in this region who are anxious and fearful.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:6-7', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:6-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those struggling with mental illness in this region, that You would bring healing and restoration to their minds.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the people in this region who are struggling with mental health issues, that You would bring peace and healing to their minds.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those who are struggling with mental illness in this region, that You would bring healing and peace to their minds.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the mental health of those in this region, that You would heal broken minds and give them peace in their hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:7', 'prayer-global-porch' ),
                'verse' => _x( 'And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.', 'Philippians 4:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those who are affected by poverty in this region, that they would experience Your provision and mercy.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 19:17', 'prayer-global-porch' ),
                'verse' => _x( 'Whoever is kind to the poor lends to the Lord, and he will reward them for what they have done.', 'Proverbs 19:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the marginalized people in this region, that You would raise up voices of justice and compassion on their behalf.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 31:8-9', 'prayer-global-porch' ),
                'verse' => _x( 'Speak up for those who cannot speak for themselves, for the rights of all who are destitute. Speak up and judge fairly; defend the rights of the poor and needy.', 'Proverbs 31:8-9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are oppressed in this region, that You would bring freedom and justice to their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 103:6', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord works righteousness and justice for all the oppressed.', 'Psalm 103:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those who are being oppressed in this region, that You would bring justice, freedom, and hope.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 103:6', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord works righteousness and justice for all the oppressed.', 'Psalm 103:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the marginalized and the oppressed in this region, that You would bring justice and restoration to their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 103:6', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord works righteousness and justice for all the oppressed.', 'Psalm 103:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those involved in human trafficking in this region, that You would bring them out of captivity and provide them with freedom.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 107:14', 'prayer-global-porch' ),
                'verse' => _x( 'He brought them out of darkness, the utter darkness, and broke away their chains.', 'Psalm 107:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the refugees in this region, that You would protect them and provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 146:9', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord watches over the foreigner and sustains the fatherless and the widow, but he frustrates the ways of the wicked.', 'Psalm 146:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the immigrants and refugees in this region, that they would find comfort, provision, and a welcoming community in Your name.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 146:9', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord watches over the foreigner and sustains the fatherless and the widow, but he frustrates the ways of the wicked.', 'Psalm 146:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the refugees and displaced people in this region, that You would provide for their needs and give them hope.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 146:9', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord watches over the foreigner and sustains the fatherless and the widow, but he frustrates the ways of the wicked.', 'Psalm 146:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the refugees and displaced persons in this region, that You would protect them and provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 146:9', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord watches over the foreigner and sustains the fatherless and the widow, but he frustrates the ways of the wicked.', 'Psalm 146:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we ask that You would provide for the needs of the refugees and displaced people in this region, offering them hope and stability.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 146:9', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord watches over the foreigner and sustains the fatherless and the widow, but he frustrates the ways of the wicked.', 'Psalm 146:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the broken-hearted in this region, that You would bring them comfort and healing through Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those experiencing emotional trauma in this region, that You would heal their wounds and restore their peace.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those who are suffering from physical and emotional wounds in this region, that You would bring them healing and comfort.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 147:3', 'prayer-global-porch' ),
                'verse' => _x( 'He heals the brokenhearted and binds up their wounds.', 'Psalm 147:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those who are experiencing poverty in this region, that You would provide for them and restore hope to their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:10', 'prayer-global-porch' ),
                'verse' => _x( 'The lions may grow weak and hungry, but those who seek the Lord lack no good thing.', 'Psalm 34:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those struggling with addiction in this region, that You would deliver them and restore them to wholeness through Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:17', 'prayer-global-porch' ),
                'verse' => _x( 'The righteous cry out, and the Lord hears them; he delivers them from all their troubles.', 'Psalm 34:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those struggling with depression in this region, that You would lift their spirits and fill them with Your peace.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the widowers in this region, that they would find solace in Your presence and community.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are in relationships marked by abuse in this region, that You would bring healing and deliverance from their suffering.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are struggling with suicidal thoughts in this region, that they would find hope and healing in You.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those struggling with depression in this region, that they would find comfort and hope in Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those suffering from depression in this region, that You would lift them up and fill them with joy and hope.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for those who are lonely in this region, that they would experience Your presence and find true companionship in You.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 34:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'Psalm 34:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that You would provide for the needs of the poor in this region, bringing provision and hope to those who are in desperate situations.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 41:1', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who have regard for the weak; the Lord delivers them in times of trouble.', 'Psalm 41:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the poor in this region, that You would bring them out of poverty and into the abundance of Your provision.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 41:1', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed are those who have regard for the weak; the Lord delivers them in times of trouble.', 'Psalm 41:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the people in this region who have been affected by natural disasters, that You would provide comfort and healing in the aftermath.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 46:1', 'prayer-global-porch' ),
                'verse' => _x( 'God is our refuge and strength, an ever-present help in trouble.', 'Psalm 46:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those affected by natural disasters in this region, that You would provide for their needs and bring restoration.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 46:1', 'prayer-global-porch' ),
                'verse' => _x( 'God is our refuge and strength, an ever-present help in trouble.', 'Psalm 46:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the orphans in this region, that You would provide for them and surround them with love and care.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask for Your provision for the orphaned and vulnerable children in this region, that they would find hope and care.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the orphans in this region, that You would be their protector and provide for their needs.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the children of single parents in this region, that they would receive the love and care they need.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those in this region who are lonely, that they would experience Your presence and find deep, meaningful relationships.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:6', 'prayer-global-porch' ),
                'verse' => _x( 'God sets the lonely in families, he leads out the prisoners with singing; but the rebellious live in a sun-scorched land.', 'Psalm 68:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we lift up the homeless in this region, asking You to provide them with shelter and bring restoration to their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:6', 'prayer-global-porch' ),
                'verse' => _x( 'God sets the lonely in families, he leads out the prisoners with singing; but the rebellious live in a sun-scorched land.', 'Psalm 68:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the homeless in this region, that they would find shelter, safety, and Your provision.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:6', 'prayer-global-porch' ),
                'verse' => _x( 'God sets the lonely in families, he leads out the prisoners with singing; but the rebellious live in a sun-scorched land.', 'Psalm 68:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those in this region who are lonely and isolated, that they would feel Your presence and be drawn into community.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:6', 'prayer-global-porch' ),
                'verse' => _x( 'God sets the lonely in families, he leads out the prisoners with singing; but the rebellious live in a sun-scorched land.', 'Psalm 68:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those dealing with loneliness in this region, that they would experience the comfort and companionship of Your presence.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:6', 'prayer-global-porch' ),
                'verse' => _x( 'God sets the lonely in families, he leads out the prisoners with singing; but the rebellious live in a sun-scorched land.', 'Psalm 68:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the homeless in this region, that You would provide them with shelter and restore their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:6', 'prayer-global-porch' ),
                'verse' => _x( 'God sets the lonely in families, he leads out the prisoners with singing; but the rebellious live in a sun-scorched land.', 'Psalm 68:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the homeless in this region, that You would provide shelter and bring stability to their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:6', 'prayer-global-porch' ),
                'verse' => _x( 'God sets the lonely in families, he leads out the prisoners with singing; but the rebellious live in a sun-scorched land.', 'Psalm 68:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the children in this region who face neglect, that You would protect them and surround them with loving, caring individuals.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 82:3', 'prayer-global-porch' ),
                'verse' => _x( 'Defend the weak and the fatherless; uphold the cause of the poor and the oppressed.', 'Psalm 82:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the marginalized in this region, that they would experience Your love and find hope in You.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 82:3', 'prayer-global-porch' ),
                'verse' => _x( 'Defend the weak and the fatherless; uphold the cause of the poor and the oppressed.', 'Psalm 82:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those seeking justice in this region, that You would bring about righteousness and truth in all situations.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 82:3', 'prayer-global-porch' ),
                'verse' => _x( 'Defend the weak and the fatherless; uphold the cause of the poor and the oppressed.', 'Psalm 82:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those affected by natural disasters in this region, that You would bring comfort and resources for rebuilding their lives.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:15', 'prayer-global-porch' ),
                'verse' => _x( 'He will call on me, and I will answer him; I will be with him in trouble, I will deliver him and honor him.', 'Psalm 91:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those facing natural disasters in this region, that You would protect them and bring aid in their time of need.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 91:4', 'prayer-global-porch' ),
                'verse' => _x( 'He will cover you with his feathers, and under his wings you will find refuge; his faithfulness will be your shield and rampart.', 'Psalm 91:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that You would bring about transformation in the lives of those who are trapped in cycles of sin and brokenness in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 12:2', 'prayer-global-porch' ),
                'verse' => _x( 'Do not conform to the pattern of this world, but be transformed by the renewing of your mind. Then you will be able to test and approve what God’s will is—his good, pleasing and perfect will.', 'Romans 12:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the mentally ill in this region, that You would bring healing to their minds and comfort to their souls.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 12:2', 'prayer-global-porch' ),
                'verse' => _x( 'Do not conform to the pattern of this world, but be transformed by the renewing of your mind. Then you will be able to test and approve what God’s will is—his good, pleasing and perfect will.', 'Romans 12:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for those who are living in despair in this region, that they would find hope in the gospel and in Your love.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 15:13', 'prayer-global-porch' ),
                'verse' => _x( 'May the God of hope fill you with all joy and peace as you trust in him, so that you may overflow with hope by the power of the Holy Spirit.', 'Romans 15:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those experiencing a lack of hope in this region, that You would fill their hearts with a confident expectation of Your goodness.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 15:13', 'prayer-global-porch' ),
                'verse' => _x( 'May the God of hope fill you with all joy and peace as you trust in him, so that you may overflow with hope by the power of the Holy Spirit.', 'Romans 15:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for those who are feeling hopeless in this region, that they may find their hope in You alone.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 15:13', 'prayer-global-porch' ),
                'verse' => _x( 'May the God of hope fill you with all joy and peace as you trust in him, so that you may overflow with hope by the power of the Holy Spirit.', 'Romans 15:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those in this region struggling with addiction, that they would find freedom in You and experience true transformation.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 6:22', 'prayer-global-porch' ),
                'verse' => _x( 'But now that you have been set free from sin and have become slaves of God, the benefit you reap leads to holiness, and the result is eternal life.', 'Romans 6:22', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for those struggling with addictions in this region, that You would provide deliverance and freedom through the power of Your Spirit.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 6:22', 'prayer-global-porch' ),
                'verse' => _x( 'But now that you have been set free from sin and have become slaves of God, the benefit you reap leads to holiness, and the result is eternal life.', 'Romans 6:22', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for those struggling with guilt and shame in this region, that they would experience the freedom and forgiveness found in You.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 8:1', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore, there is now no condemnation for those who are in Christ Jesus.', 'Romans 8:1', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_love_and_generosity( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Love', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, give the believers of the %1$s of %2$s unity and humility as they work to bring the kingdom to new people and places.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, stir the hearts of your people in %1$s to agree with you and with one another.', 'prayer-global-porch' ), $stack['location']['name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, stir the hearts of your people in %1$s of %2$s to agree with you and with one another in love.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'John 17:21', 'prayer-global-porch' ),
                'verse' => _x( 'that all of them may be one, Father, just as you are in me and I am in you. May they also be in us so that the world may believe that you have sent me.', 'John 17:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Lord, we pray for the believers in %1$s to be more like Jesus in their love for friends and enemies.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Matthew 5:44', 'prayer-global-porch' ),
                'verse' => _x( 'But I tell you, love your enemies and pray for those who persecute you.', 'Matthew 5:44', 'prayer-global-porch' ),
            ],
            [
                'section_label' => __( 'The Church', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'Father, let love abound more and more in the church of %1$s.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Philippians 1:9', 'prayer-global-porch' ),
                'verse' => _x( 'And this is my prayer: that your love may abound more and more in knowledge and depth of insight', 'Philippians 1:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => __( 'Generosity', 'prayer-global-porch' ),
                'prayer' => sprintf( __( 'God, we pray for the believers in %1$s to be generous so that they would be worthy of greater investment by you.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => '',
                'verse' => '',
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, encourage the %1$s believers in %2$s to not just be consumers of knowledge but be producers of love, mercy, kindness, and justice.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['name'] ),
                'reference' => __( '1 John 3:18', 'prayer-global-porch' ),
                'verse' => _x( 'let us not love with words or speech but with actions and in truth.', '1 John 3:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Oh Lord, show the fatherless in %1$s of %2$s that you can be their real Father.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( '2 Corinthians 6:18', 'prayer-global-porch' ),
                'verse' => _x( 'I will be to you a Father. you will be to me sons and daughters,’ says the Lord Almighty.', '2 Corinthians 6:18', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, help us to serve those in need in this region, reflecting your love and compassion in practical ways.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 23:11', 'prayer-global-porch' ),
                'verse' => _x( 'But the greatest among you shall be your servant.', 'Matthew 23:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that you bless the churches in this region with a spirit of generosity to help those in need.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 6:38', 'prayer-global-porch' ),
                'verse' => _x( 'Give, and it will be given to you.', 'Luke 6:38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the elderly in this region, that they may be honored and cared for in their later years.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'Gray hair is a crown of splendor; it is attained in the way of righteousness.', 'Proverbs 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the elderly in this region. May they find comfort, dignity, and community as they grow in their walk with you.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 16:31', 'prayer-global-porch' ),
                'verse' => _x( 'Gray hair is a crown of splendor; it is attained in the way of righteousness.', 'Proverbs 16:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that your Church in this region would grow in unity and love, shining the light of Christ to all who see.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 133:1', 'prayer-global-porch' ),
                'verse' => _x( 'How good and pleasant it is when God’s people live together in unity!', 'Psalm 133:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the homeless in this region, that they would find shelter, safety, and compassion in your name.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 25:35', 'prayer-global-porch' ),
                'verse' => _x( 'For I was hungry and you gave me something to eat, I was thirsty and you gave me something to drink, I was a stranger and you invited me in,', 'Matthew 25:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we lift up the business owners in this region. May they seek your wisdom in every decision and conduct their work with integrity and excellence. Let their businesses be a reflection of your character, and may they steward their resources in ways that bless others and advance your Kingdom purposes.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 10:31', 'prayer-global-porch' ),
                'verse' => _x( 'So whether you eat or drink or whatever you do, do it all for the glory of God.', '1 Corinthians 10:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would fill the hearts of the people in this region with Your love, and that they would be moved to serve others with kindness and generosity.', 'prayer-global-porch' ),
                'reference' => __( '1 John 4:19', 'prayer-global-porch' ),
                'verse' => _x( 'We love because he first loved us.', '1 John 4:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for a spirit of generosity in this region, that the people would share their resources and bless those in need.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 9:7', 'prayer-global-porch' ),
                'verse' => _x( 'Each of you should give what you have decided in your heart to give, not reluctantly or under compulsion, for God loves a cheerful giver.', '2 Corinthians 9:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for Your provision for the local churches in this region, that they would have the resources needed to carry out their mission.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 9:8', 'prayer-global-porch' ),
                'verse' => _x( 'And God is able to bless you abundantly, so that in all things at all times, having all that you need, you will abound in every good work.', '2 Corinthians 9:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for those in this region facing relational brokenness, that You would bring healing and restoration to their relationships.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:13', 'prayer-global-porch' ),
                'verse' => _x( 'Bear with each other and forgive one another if any of you has a grievance against someone. Forgive as the Lord forgave you.', 'Colossians 3:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the marriages in this region, that they would be strengthened through Your love and commitment.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we lift up the marriages in this region. May they be rooted in Your love and reflect the selfless, sacrificial love of Christ in every season.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the marriages in this region, that they would be strengthened by Your love and reflect the sacrificial love of Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:25', 'prayer-global-porch' ),
                'verse' => _x( 'Husbands, love your wives, just as Christ loved the church and gave himself up for her', 'Ephesians 5:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the artists in this region, that they would use their talents to glorify You and inspire others.', 'prayer-global-porch' ),
                'reference' => __( 'Exodus 35:31-32', 'prayer-global-porch' ),
                'verse' => _x( 'and he has filled him with the Spirit of God, with wisdom, with understanding, with knowledge and with all kinds of skills--to make artistic designes for work in gold, silver and bronze.', 'Exodus 35:31-32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the homeless in this region, that they would find shelter and care, and experience Your love through Your people.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 58:7', 'prayer-global-porch' ),
                'verse' => _x( 'Is it not to share your food with the hungry and to provide the poor wanderer with shelter—when you see the naked, to clothe them, and not to turn away from your own flesh and blood?', 'Isaiah 58:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the homeless in this region, that they would find shelter, food, and most importantly, the love of Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 58:7', 'prayer-global-porch' ),
                'verse' => _x( 'Is it not to share your food with the hungry and to provide the poor wanderer with shelter—when you see the naked, to clothe them, and not to turn away from your own flesh and blood?', 'Isaiah 58:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the marginalized in this region, that they would experience Your love and find acceptance within the community.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 4:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Lord is on me, because he has anointed me to proclaim good news to the poor. He has sent me to proclaim freedom for the prisoners and recovery of sight for the blind, to set the oppressed free,', 'Luke 4:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the incarcerated individuals in this region, that they would encounter Your love and truth, finding freedom in You.', 'prayer-global-porch' ),
                'reference' => __( 'Luke 4:18', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Lord is on me, because he has anointed me to proclaim good news to the poor. He has sent me to proclaim freedom for the prisoners and recovery of sight for the blind, to set the oppressed free,', 'Luke 4:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for the leaders in this region, that they would lead with humility, wisdom, and integrity, seeking to serve the people.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 10:44-45', 'prayer-global-porch' ),
                'verse' => _x( 'And whoever wants to be first must be slave of all. For even the Son of Man did not come to be served, but to serve, and to give his life as a ransom for many.', 'Mark 10:44-45', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the leaders of the Church in this region, that they would lead with humility and a heart of service.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 10:45', 'prayer-global-porch' ),
                'verse' => _x( 'For even the Son of Man did not come to be served, but to serve, and to give his life as a ransom for many.', 'Mark 10:45', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for an outpouring of love and compassion to fill the hearts of those who are struggling with poverty in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 14:31', 'prayer-global-porch' ),
                'verse' => _x( 'Whoever oppresses the poor shows contempt for their Maker, but whoever is kind to the needy honors God.', 'Proverbs 14:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask for Your provision to meet the needs of the poor in this region, that they would know Your love through the generosity of others.', 'prayer-global-porch' ),
                'reference' => __( 'Proverbs 19:17', 'prayer-global-porch' ),
                'verse' => _x( 'Whoever is kind to the poor lends to the Lord, and he will reward them for what they have done.', 'Proverbs 19:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the children of incarcerated parents in this region, that You would comfort them and provide for their emotional and spiritual needs.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the orphans in this region, that they would find families who love and care for them, and experience Your fatherly love.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 68:5', 'prayer-global-porch' ),
                'verse' => _x( 'A father to the fatherless, a defender of widows, is God in his holy dwelling.', 'Psalm 68:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the communities in this region, that they would experience unity, peace, and love in Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 12:16', 'prayer-global-porch' ),
                'verse' => _x( 'Live in harmony with one another. Do not be proud, but be willing to associate with people of low position. Do not be conceited.', 'Romans 12:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask for Your grace to be evident in this region, that Your love would overflow to those in need.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 5:20', 'prayer-global-porch' ),
                'verse' => _x( 'But where sin increased, grace increased all the more.', 'Romans 5:20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that Your love would spread throughout the hearts of the people in this region, breaking down every wall of division.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 5:5', 'prayer-global-porch' ),
                'verse' => _x( 'And hope does not put us to shame, because God’s love has been poured out into our hearts through the Holy Spirit, who has been given to us.', 'Romans 5:5', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_kingdom_urgency( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Urgency', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, give the disciples of the %1$s of %2$s an urgency of seeing every people and place reached for the gospel.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'John 9:4', 'prayer-global-porch' ),
                'verse' => _x( 'As long as it is day, we must do the works of him who sent me. Night is coming, when no one can work.', 'John 9:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, encourage the disciples in %1$s to live with urgency and a passion for making more disciples.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'James 4:14', 'prayer-global-porch' ),
                'verse' => _x( 'Yet you do not know what your life will be like tomorrow. you are just a vapor that appears for a little while and then vanishes away.', 'James 4:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, defend the church in %1$s of %2$s against being inward-focused.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Isaiah 61:1', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Sovereign LORD is on me, because the LORD has anointed me to proclaim good news to the poor. He has sent me to bind up the brokenhearted, to proclaim freedom for the captives and release from darkness for the prisoners.', 'Isaiah 61:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, encourage the church in %1$s to make the most of every opportunity.', 'prayer-global-porch' ), $stack['location']['full_name'] ),
                'reference' => __( 'Ephesians 5:15-16', 'prayer-global-porch' ),
                'verse' => _x( 'Be very careful, then, how you live—not as unwise but as wise, making the most of every opportunity, because the days are evil.', 'Ephesians 5:15-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, your return is closer than when we first believed. Please, set urgency in the hearts of the people living in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Romans 13:11', 'prayer-global-porch' ),
                'verse' => _x( 'Besides this you know the time, that the hour has come for you to wake from sleep. For salvation is nearer to us now than when we first believed.', 'Romans 13:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, disrupt complacency in the %1$s believers living in %2$s of %3$s. Remind them you are coming soon.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Matthew 24:42', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore, stay awake, for you do not know on what day your Lord is coming.', 'Matthew 24:42', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, give faith and responsive hearts to the %1$s citizens of the %2$s of %3$s.', 'prayer-global-porch' ), $stack['location']['population'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Isaiah 55:6', 'prayer-global-porch' ),
                'verse' => _x( 'Seek the Lord while he may be found; call upon him while he is near.', 'Isaiah 55:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, renew the call of John the Baptist in %1$s of %2$s. Send out bold servants who will call all to repent.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Matthew 3:2', 'prayer-global-porch' ),
                'verse' => _x( 'Repent, for the kingdom of heaven is at hand.', 'Matthew 3:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Father, set on fire the hearts and passion of your church in %1$s of %2$s.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Romans 12:11', 'prayer-global-porch' ),
                'verse' => _x( 'Do not be slothful in zeal, be fervent in spirit, serve the Lord.', 'Romans 12:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Spirit, awaken the sleepers and call them to repent and be baptized in %1$s of %2$s. Set an urgency in their hearts.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Acts 22:16', 'prayer-global-porch' ),
                'verse' => _x( 'And now why do you wait? Rise and be baptized and wash away your sins, calling on his name.’', 'Acts 22:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, defend your people in %1$s of %2$s against the difficulty of these last days.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( '2 Timothy 3:1-5a', 'prayer-global-porch' ),
                'verse' => _x( 'But mark this: There will be terrible times in the last days. 2 People will be lovers of themselves, lovers of money, boastful, proud, abusive, disobedient to their parents, ungrateful, unholy, 3 without love, unforgiving, slanderous, without self-control, brutal, not lovers of the good, 4 treacherous, rash, conceited, lovers of pleasure rather than lovers of God— 5 having a form of godliness but denying its power.', '2 Timothy 3:1-5a', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Jesus, purify the %1$s believers in %2$s of %3$s to not just be hearers, but doers of your Word.', 'prayer-global-porch' ), $stack['location']['believers'], $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Revelation 1:3', 'prayer-global-porch' ),
                'verse' => _x( 'Blessed is the one who reads aloud the words of this prophecy, and blessed are those who hear it and take to heart what is written in it, because the time is near.', 'Revelation 1:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => sprintf( __( 'Holy Spirit, have mercy on the simple who turned from you in %1$s of %2$s. Warn them again against their complacency.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], $stack['location']['name'] ),
                'reference' => __( 'Proverbs 1:32', 'prayer-global-porch' ),
                'verse' => _x( 'For the simple are killed by their turning away, and the complacency of fools destroys them;', 'Proverbs 1:32', 'prayer-global-porch' ),
            ],
        ];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the church in this country grow in love, unity, and in its desire to see others saved.', 'prayer-global-porch' ),
                'reference' => __( 'John 15:12', 'prayer-global-porch' ),
                'verse' => _x( 'My command is this: Love each other as I have loved you.', 'John 15:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray that your presence would be known throughout this region, that many would experience your love and grace.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 24:1', 'prayer-global-porch' ),
                'verse' => _x( 'The earth is the Lord’s, and everything in it, the world, and all who live in it;', 'Psalm 24:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we lift up this region to You today, asking that Your kingdom come and Your will be done across every city and village.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'your kingdom come, your will be done, on earth as it is in heaven.', 'Matthew 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray that Your Kingdom would come in this country, bringing peace, justice, and hope.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'your kingdom come, your will be done, on earth as it is in heaven.', 'Matthew 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray that Your Kingdom would come in this region, bringing restoration and healing to every part of society.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'your kingdom come, your will be done, on earth as it is in heaven.', 'Matthew 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray that Your Kingdom would come and Your will would be done in this region, as it is in heaven.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'your kingdom come, your will be done, on earth as it is in heaven.', 'Matthew 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may Your kingdom be established in every sphere of life in this region—from government to education, to business, to the home.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 145:13', 'prayer-global-porch' ),
                'verse' => _x( 'Your kingdom is an everlasting kingdom, and your dominion endures through all generations.', 'Psalm 145:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for Your Spirit to stir the hearts of the young people in this region, drawing them to Your kingdom and purpose.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the youth in this region, that they would grow strong in their faith and make a lasting impact for Your kingdom.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the young people in this region, that they would rise up with boldness and stand firm in their faith.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we pray for the youth in this region, that they would have a deep encounter with You and be equipped to be bold witnesses of Your truth.', 'prayer-global-porch' ),
                'reference' => __( '1 Timothy 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity.', '1 Timothy 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the church in this region to be bold in its faith and share the gospel with compassion and clarity.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 4:29', 'prayer-global-porch' ),
                'verse' => _x( 'Now, Lord, consider their threats and enable your servants to speak your word with great boldness.', 'Acts 4:29', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that You would equip believers in this region to share the gospel with boldness and compassion, reaching those who are far from You.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 4:29', 'prayer-global-porch' ),
                'verse' => _x( 'Now, Lord, consider their threats and enable your servants to speak your word with great boldness.', 'Acts 4:29', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for the churches in this region, that they would be filled with Your Spirit and bold in sharing the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 4:31', 'prayer-global-porch' ),
                'verse' => _x( 'After they prayed, the place where they were meeting was shaken. And they were all filled with the Holy Spirit and spoke the word of God boldly.', 'Acts 4:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we pray for the churches in this region, that they may be filled with Your Spirit and courageously proclaim the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 4:31', 'prayer-global-porch' ),
                'verse' => _x( 'After they prayed, the place where they were meeting was shaken. And they were all filled with the Holy Spirit and spoke the word of God boldly.', 'Acts 4:31', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray for Your Church in this region, that it would be strong, unified, and filled with the Spirit to accomplish Your will.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for unity among believers in this region, that they may work together to bring glory to Your name.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Make every effort to keep the unity of the Spirit through the bond of peace.', 'Ephesians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we ask that Your Kingdom would manifest in this region, bringing restoration and healing to every area of society.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 61:1-2', 'prayer-global-porch' ),
                'verse' => _x( 'The Spirit of the Sovereign Lord is on me, because the Lord has anointed me to proclaim good news to the poor. He has sent me to bind up the brokenhearted, to proclaim freedom for the captives and release from darkness for the prisoners, to proclaim the year of the Lord’s favor and the day of vengeance of our God, to comfort all who mourn,', 'Isaiah 61:1-2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Yahweh, we ask that Your Spirit would move among the youth in this region, calling them to serve You with passion and purpose.', 'prayer-global-porch' ),
                'reference' => __( 'Joel 2:28', 'prayer-global-porch' ),
                'verse' => _x( 'And afterward, I will pour out my Spirit on all people. Your sons and daughters will prophesy, your old men will dream dreams, your young men will see visions.', 'Joel 2:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, may the church in this region grow in love, unity, and faith, becoming a strong witness to the surrounding community.', 'prayer-global-porch' ),
                'reference' => __( 'John 13:35', 'prayer-global-porch' ),
                'verse' => _x( 'By this everyone will know that you are my disciples, if you love one another.', 'John 13:35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, we pray that Your Kingdom would expand in this region, reaching into every corner of society, transforming lives for Your glory.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 13:31-32', 'prayer-global-porch' ),
                'verse' => _x( 'He told them another parable: ‘The kingdom of heaven is like a mustard seed, which a man took and planted in his field. Though it is the smallest of all seeds, yet when it grows, it is the largest of garden plants and becomes a tree, so that the birds come and perch in its branches.’', 'Matthew 13:31-32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask for the arrival of Your Kingdom in this region, bringing healing, restoration, and lasting peace.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'Your kingdom come, your will be done, on earth as it is in heaven.', 'Matthew 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, we ask that Your kingdom would come to this region, bringing healing, restoration, and peace.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'Your kingdom come, your will be done, on earth as it is in heaven.', 'Matthew 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we ask that Your Kingdom would be established in this region, and that Your will would be accomplished here just as it is in heaven.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'Your kingdom come, your will be done, on earth as it is in heaven.', 'Matthew 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we bring this region before You, praying that Your kingdom will be established and Your will fulfilled in every community, town, and neighborhood.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'Your kingdom come, your will be done, on earth as it is in heaven.', 'Matthew 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Savior, we pray for Your kingdom to come in this region, bringing peace, justice, and healing to the people.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'Your kingdom come, your will be done, on earth as it is in heaven.', 'Matthew 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the churches in this region to be united, standing together as one body for the gospel of Christ.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 1:27', 'prayer-global-porch' ),
                'verse' => _x( 'Whatever happens, conduct yourselves in a manner worthy of the gospel of Christ. Then, whether I come and see you or only hear about you in my absence, I will know that you stand firm in the one Spirit, striving together with one mind for the faith of the gospel.', 'Philippians 1:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, we pray for the youth in this region, that they would have a deep and lasting encounter with You that shapes their lives for Your Kingdom.', 'prayer-global-porch' ),
                'reference' => __( 'Psalm 119:9', 'prayer-global-porch' ),
                'verse' => _x( 'How can a young person stay on the path of purity? By living according to your word.', 'Psalm 119:9', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _for_unity_and_working_together( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'Unity and Working Together', 'prayer-global-porch' );
        $current_templates = [];
        $ai_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, just as a body has many parts that work together, unite your people here as one body to make disciples. Let each believer use their unique gifts to strengthen the whole, so this place might see the power of your unified Church.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 12:12-27', 'prayer-global-porch' ),
                'verse' => _x( 'For just as the body is one and has many members, and all the members of the body, though many, are one body, so it is with Christ.', '1 Corinthians 12:12-27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, raise up apostles, prophets, evangelists, pastors and teachers in this place. Let them equip your people for works of service, building up the body until all here reach unity in faith and knowledge of you.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:11-16', 'prayer-global-porch' ),
                'verse' => _x( 'And he gave the apostles, the prophets, the evangelists, the shepherds and teachers, to equip the saints for the work of ministry, for building up the body of Christ.', 'Ephesians 4:11-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, distribute your gifts among believers here for the common good. Let prophecy, wisdom, knowledge, faith, healing, miracles, and discernment flow through them to reach the lost and build your Church.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 12:4-11', 'prayer-global-porch' ),
                'verse' => _x( 'Now there are varieties of gifts, but the same Spirit; and there are varieties of service, but the same Lord... To each is given the manifestation of the Spirit for the common good.', '1 Corinthians 12:4-11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Christ, be the head of your church in this region. Let your body here grow strong under your leadership, reaching out to embrace every person who doesn\'t yet know you as Savior.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 1:18', 'prayer-global-porch' ),
                'verse' => _x( 'And he is the head of the body, the church. He is the beginning, the firstborn from the dead, that in everything he might be preeminent.', 'Colossians 1:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, let your Church here truly be Christ\'s body, the fullness of him who fills everything. May this community experience the complete presence of Jesus and overflow that fullness to the unreached around them.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 1:22-23', 'prayer-global-porch' ),
                'verse' => _x( 'And he put all things under his feet and gave him as head over all things to the church, which is his body, the fullness of him who fills all in all.', 'Ephesians 1:22-23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, as believers here share one loaf together, make them conscious that they are one body. Let this unity compel them to invite others to your table and into your family.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 10:17', 'prayer-global-porch' ),
                'verse' => _x( 'Because there is one bread, we who are many are one body, for we all partake of the one bread.', '1 Corinthians 10:17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, help your people here understand that their bodies are members of Christ himself. Let this truth drive them to live holy lives that draw the lost to you.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 6:15', 'prayer-global-porch' ),
                'verse' => _x( 'Do you not know that your bodies are members of Christ? Shall I then take the members of Christ and make them members of a prostitute? Never!', '1 Corinthians 6:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, you have reconciled different peoples in one body through the cross. Show this reality to the divided communities here, and let your Church model the reconciliation that leads to salvation.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 2:16', 'prayer-global-porch' ),
                'verse' => _x( 'And might reconcile us both to God in one body through the cross, thereby killing the hostility.', 'Ephesians 2:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Christ, as head of the Church, lead your body in this place toward fruitful evangelism. Let your people here submit to your direction and multiply disciples throughout this region.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:23', 'prayer-global-porch' ),
                'verse' => _x( 'For the husband is the head of the wife even as Christ is the head of the church, his body, and is himself its Savior.', 'Ephesians 5:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, let believers here truly know they are members of your body. Make this identity so real that they cannot help but work together to reach those who remain outside your family.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 5:30', 'prayer-global-porch' ),
                'verse' => _x( 'For we are members of his body.', 'Ephesians 5:30', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, help your Church here stay connected to you as head. Cause it to grow, helping it reach every corner of this place with the gospel.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 2:19', 'prayer-global-porch' ),
                'verse' => _x( 'And not holding fast to the Head, from whom the whole body, nourished and knit together through its joints and ligaments, grows with a growth that is from God.', 'Colossians 2:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, let the peace of Christ rule in the hearts of believers here as members of one body. May this peace overflow to bring others into your kingdom and your family.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 3:15', 'prayer-global-porch' ),
                'verse' => _x( 'And let the peace of Christ rule in your hearts, to which indeed you were called in one body. And be thankful.', 'Colossians 3:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, teach your people here about spiritual gifts. Help them understand these gifts come from you and are meant to serve others.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 12:1-3', 'prayer-global-porch' ),
                'verse' => _x( 'Now concerning spiritual gifts, brothers, I do not want you to be uninformed... no one speaking in the Spirit of God ever says \'Jesus is accursed,\' and no one can say \'Jesus is Lord\' except in the Holy Spirit.', '1 Corinthians 12:1-3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, let believers here excel in gifts that build up the Church. Make your body strong in this place so it can effectively reach the lost with your love and truth.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 14:12', 'prayer-global-porch' ),
                'verse' => _x( 'So with yourselves, since you are eager for manifestations of the Spirit, strive to excel in building up the church.', '1 Corinthians 14:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, help your people here make every effort to keep the unity of the Spirit. Let this unity become a powerful witness that draws the unreached to faith in Jesus.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:1-6', 'prayer-global-porch' ),
                'verse' => _x( 'I therefore, a prisoner for the Lord, urge you to walk in a manner worthy of the calling to which you have been called... eager to maintain the unity of the Spirit in the bond of peace.', 'Ephesians 4:1-6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, since we are all members of one body, help believers here speak truthfully with one another and work together to speak your truth to those who have never heard.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 4:25', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore, having put away falsehood, let each one of you speak the truth with his neighbor, for we are members one of another.', 'Ephesians 4:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, help people here to use the gifts you\'ve given them - prophecy, serving, teaching, encouraging, giving, leading, showing mercy. Let these gifts multiply disciples throughout this region.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 12:6-8', 'prayer-global-porch' ),
                'verse' => _x( 'Having gifts that differ according to the grace given to us, let us use them: if prophecy... if service... if teaching... if exhorting... if contributing... if leading... if showing mercy...', 'Romans 12:6-8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, let each believer here use whatever gift they have to serve others. Make your Church a serving community that draws the lost to experience your love through their actions.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 4:10-11', 'prayer-global-porch' ),
                'verse' => _x( 'As each has received a gift, use it to serve one another, as good stewards of God\'s varied grace.', '1 Peter 4:10-11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, break down every barrier here. Let all who follow Jesus - regardless of background - be truly one in Christ, creating a witness that compels others to join your family.', 'prayer-global-porch' ),
                'reference' => __( 'Galatians 3:28', 'prayer-global-porch' ),
                'verse' => _x( 'There is neither Jew nor Greek, there is neither slave nor free, there is no male and female, for you are all one in Christ Jesus.', 'Galatians 3:28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, give believers here true fellowship with one another. Let this deep community become a light in the darkness, showing the unreached what life in your kingdom looks like.', 'prayer-global-porch' ),
                'reference' => __( '1 John 1:7', 'prayer-global-porch' ),
                'verse' => _x( 'But if we walk in the light, as he is in the light, we have fellowship with one another, and the blood of Jesus his Son cleanses us from all sin.', '1 John 1:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, unite your people here with you in death to sin and resurrection to new life. Let this transformed life become irresistible to those still walking in darkness.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 6:5', 'prayer-global-porch' ),
                'verse' => _x( 'For if we have been united with him in a death like his, we shall certainly be united with him in a resurrection like his.', 'Romans 6:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, help believers here understand they died to the law through the body of Christ. Free them to live by grace and bear fruit.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 7:4', 'prayer-global-porch' ),
                'verse' => _x( 'Likewise, my brothers, you also have died to the law through the body of Christ, so that you may belong to another... in order that we may bear fruit for God.', 'Romans 7:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, help your people here properly discern the body of the Lord when they gather. Let their unity in worship become a powerful witness to watching unbelievers.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 11:29', 'prayer-global-porch' ),
                'verse' => _x( 'Whoever, therefore, eats the bread or drinks the cup of the Lord in an unworthy manner will be guilty concerning the body and blood of the Lord.', '1 Corinthians 11:29', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, help your people here do good to all, especially to those in the family of believers. Let this love overflow to reach those who have never experienced your family\'s care.', 'prayer-global-porch' ),
                'reference' => __( 'Galatians 6:10', 'prayer-global-porch' ),
                'verse' => _x( 'And as for you, brothers, do good to everyone, and especially to those who are of the household of faith.', 'Galatians 6:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, help believers here fill up what is lacking in your afflictions for the sake of your body. Give them joy in suffering as they reach the lost.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 1:24', 'prayer-global-porch' ),
                'verse' => _x( 'Now I rejoice in my sufferings for your sake, and in my flesh I am filling up what is lacking in Christ\'s afflictions for the sake of his body, that is, the church.', 'Colossians 1:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, don\'t let your people here give up meeting together. Make their gatherings so filled with your presence that outsiders are drawn to join them and discover you.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 10:25', 'prayer-global-porch' ),
                'verse' => _x( 'Not neglecting to meet together, as is the habit of some, but encouraging one another, and all the more as you see the Day drawing near.', 'Hebrews 10:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, your people here are like living stones being built into a spiritual house. Make this dwelling place of your Spirit attractive to those who have never experienced your presence.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 2:5', 'prayer-global-porch' ),
                'verse' => _x( 'As you come to him, a living stone... you yourselves like living stones are being built up as a spiritual house, to be a holy priesthood...', '1 Peter 2:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, weave believers here together like a cord of three strands. Make their unity in mission unbreakable as they work together to reach everyone here.', 'prayer-global-porch' ),
                'reference' => __( 'Ecclesiastes 4:12', 'prayer-global-porch' ),
                'verse' => _x( 'Though one may be overpowered, two can defend themselves. A cord of three strands is not quickly broken.', 'Ecclesiastes 4:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, you give the growth, but let your servants here plant and water faithfully. Show them they are co-workers in your service, each playing their part in the harvest.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 3:6-9', 'prayer-global-porch' ),
                'verse' => _x( 'I planted, Apollos watered, but God gave the growth... For we are God\'s fellow workers. You are God\'s field, God\'s building.', '1 Corinthians 3:6-9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, help believers here stand firm in one Spirit, striving together as one for the faith of the gospel. Let nothing divide them from this shared mission to the lost.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 1:27', 'prayer-global-porch' ),
                'verse' => _x( 'Only let your manner of life be worthy of the gospel of Christ... standing firm in one spirit, with one mind striving side by side for the faith of the gospel.', 'Philippians 1:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, like the people rebuilding Jerusalem\'s wall, help your Church here work with all their heart to build your kingdom in this region. Give them unified purpose and determination.', 'prayer-global-porch' ),
                'reference' => __( 'Nehemiah 4:6', 'prayer-global-porch' ),
                'verse' => _x( 'So the wall was built... for the people had a mind to work.', 'Nehemiah 4:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, others have done hard work, and let your people here reap the benefits. Connect them with the faithful who came before, and help them build on that foundation.', 'prayer-global-porch' ),
                'reference' => __( 'John 4:35-38', 'prayer-global-porch' ),
                'verse' => _x( 'Do you not say, \'There are yet four months, then comes the harvest\'? Look, I tell you, lift up your eyes, and see that the fields are white for harvest... Others have labored, and you have entered into their labor.', 'John 4:35-38', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, set apart believers here for the work you\'ve called them to. Send them out like the church at Antioch sent Paul and Barnabas to reach the unreached.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 13:2-3', 'prayer-global-porch' ),
                'verse' => _x( 'While they were worshiping the Lord and fasting, the Holy Spirit said, \'Set apart for me Barnabas and Saul for the work to which I have called them.\'', 'Acts 13:2-3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, raise up co-workers in Christ Jesus in this place. Help your people partner together in the gospel work, supporting and encouraging one another in the mission.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 16:3', 'prayer-global-porch' ),
                'verse' => _x( 'Greet Prisca and Aquila, my fellow workers in Christ Jesus.', 'Romans 16:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, like Titus and others were representatives of the churches, send out ambassadors from this place who will carry your gospel to unreached areas and peoples.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 8:23', 'prayer-global-porch' ),
                'verse' => _x( 'As for Titus, he is my partner and fellow worker for your benefit. And as for our brothers, they are messengers of the churches, the glory of Christ.', '2 Corinthians 8:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, let believers here contend side by side in the cause of the gospel. Give them partners who will fight alongside them to see souls saved in this region.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 4:3', 'prayer-global-porch' ),
                'verse' => _x( 'Yes, I ask you also, true companion, help these women, who have labored side by side with me in the gospel...', 'Philippians 4:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, raise up co-workers in your service here like Timothy. Send them to encourage and strengthen the work of reaching the lost throughout this area.', 'prayer-global-porch' ),
                'reference' => __( '1 Thessalonians 3:2', 'prayer-global-porch' ),
                'verse' => _x( 'For this reason I sent you Timothy, my beloved and faithful child in the Lord, to remind you of my ways in Christ...', '1 Thessalonians 3:2', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Holy Spirit, create the same unity here that marked the early church. Let believers devote themselves to teaching, fellowship, breaking bread, and prayer as they reach their community.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 2:42-47', 'prayer-global-porch' ),
                'verse' => _x( 'And they devoted themselves to the apostles\' teaching and the fellowship, to the breaking of bread and the prayers... And the Lord added to their number day by day those who were being saved.', 'Acts 2:42-47', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, make all believers here one in heart and mind. Let this remarkable unity convince the watching world that you are real and that Jesus is your Son.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 4:32', 'prayer-global-porch' ),
                'verse' => _x( 'Now the full number of those who believed were of one heart and soul...', 'Acts 4:32', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, like the early church appointed deacons, help believers here organize to serve together effectively. Let nothing hinder the spread of your word in this place.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 6:1-7', 'prayer-global-porch' ),
                'verse' => _x( 'And the twelve called together the whole multitude of the disciples and said... \'Pick out from among you seven men of good repute, full of the Spirit and of wisdom, whom we will appoint to this duty.\'', 'Acts 6:1-7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, scatter believers from here like those from Jerusalem. Let persecution or circumstances spread them out to plant churches in unreached areas throughout this region.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 11:19-26', 'prayer-global-porch' ),
                'verse' => _x( 'Now those who were scattered because of the persecution that arose over Stephen traveled as far as Phoenicia and Cyprus and Antioch, speaking the word...', 'Acts 11:19-26', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, give wisdom to church leaders here like you did to the Jerusalem Council. Help them work together on important decisions that will advance the gospel to unreached peoples.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 15:22-35', 'prayer-global-porch' ),
                'verse' => _x( 'Then it seemed good to the apostles and the elders, with the whole church, to choose men from among them and send them to Antioch with Paul and Barnabas...', 'Acts 15:22-35', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, help believers here join in the struggle through prayer. Unite them in intercession for the advance of your kingdom and the salvation of the lost.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 15:30', 'prayer-global-porch' ),
                'verse' => _x( 'I appeal to you, brothers, by our Lord Jesus Christ and by the love of the Spirit, to strive together with me in your prayers to God on my behalf.', 'Romans 15:30', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, put your servants here on display like a spectacle to the world. Let their transformed lives and unified mission become a powerful witness to watching unbelievers.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 4:9', 'prayer-global-porch' ),
                'verse' => _x( 'For it seems to me that God has exhibited us apostles as last of all, like men sentenced to death, because we have become a spectacle to the world...', '1 Corinthians 4:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, help your people here submit to those who join in the work. Create harmony among laborers so the gospel can advance without hindrance throughout this region.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 16:15-16', 'prayer-global-porch' ),
                'verse' => _x( 'I urge you, then, be imitators of me. That is why I sent you Timothy... Now I urge you, brothers—you know that the household of Stephanas... they have devoted themselves to the service of the saints—be subject to such as these, and to every fellow worker and laborer.', '1 Corinthians 16:15-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, provide faithful helpers here like Mark was to Paul. Send encouragers and assistants who will strengthen the hands of those reaching the lost.', 'prayer-global-porch' ),
                'reference' => __( '2 Timothy 4:11', 'prayer-global-porch' ),
                'verse' => _x( 'Get Mark and bring him with you, for he is very useful to me for ministry.', '2 Timothy 4:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, raise up dear friends and fellow workers here like Philemon. Let homes open and resources flow to support the work of evangelism in this place.', 'prayer-global-porch' ),
                'reference' => __( 'Philemon 1:1', 'prayer-global-porch' ),
                'verse' => _x( 'To Philemon our beloved fellow worker and Apphia our sister and Archippus our fellow soldier, and to the church in your house.', 'Philemon 1:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, help believers here show hospitality to gospel workers so they may work together for the truth. Make this place a sending and supporting hub for missions.', 'prayer-global-porch' ),
                'reference' => __( '3 John 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'Beloved, it is a faithful thing you do in all your efforts for these brothers, strangers as they are... so that we may be fellow workers for the truth.', '3 John 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, send out the twelve-like teams from here with power and authority over demons and diseases. Let signs and wonders accompany their preaching to confirm your word.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 10:1-16', 'prayer-global-porch' ),
                'verse' => _x( 'And he called to him his twelve disciples and gave them authority over unclean spirits, to cast them out, and to heal every disease and every affliction.', 'Matthew 10:1-16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, where two or three gather here in your name, be with them. Let your gathered church bring change.', 'prayer-global-porch' ),
                'reference' => __( 'Matthew 18:19-20', 'prayer-global-porch' ),
                'verse' => _x( 'For where two or three are gathered in my name, there am I among them.', 'Matthew 18:19-20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, send disciples from here two by two like Jesus did. Give them authority and power, and let them return with joy at what you accomplish through them.', 'prayer-global-porch' ),
                'reference' => __( 'Mark 6:7', 'prayer-global-porch' ),
                'verse' => _x( 'And he called the twelve and began to send them out two by two, and gave them authority over the unclean spirits.', 'Mark 6:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, make believers here one just as you and the Father are one. Let this unity convince the world that the Father sent you and loves them as he loves you.', 'prayer-global-porch' ),
                'reference' => __( 'John 17:20-23', 'prayer-global-porch' ),
                'verse' => _x( 'I do not ask for these only, but also for those who will believe in me through their word, that they may all be one... so that the world may believe that you have sent me.', 'John 17:20-23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Holy Spirit, send leaders from here to check on new believers like Peter and John went to Samaria. Strengthen and establish the churches throughout this region.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 8:14-17', 'prayer-global-porch' ),
                'verse' => _x( 'Now when the apostles at Jerusalem heard that Samaria had received the word of God, they sent to them Peter and John.', 'Acts 8:14-17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, raise up advocates here like Barnabas who brought Paul to the apostles. Help believers embrace former enemies who have truly encountered Jesus.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 9:27', 'prayer-global-porch' ),
                'verse' => _x( 'But Barnabas took him and brought him to the apostles and declared to them how on the road he had seen the Lord...', 'Acts 9:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, send encouragers like Barnabas to this place. Let them see your grace at work and urge believers to remain true to you with all their hearts.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 11:22-24', 'prayer-global-porch' ),
                'verse' => _x( 'News of this came to the ears of the church in Jerusalem, and they sent Barnabas to Antioch. When he came and saw the grace of God, he was glad, and he exhorted them all to remain faithful to the Lord with steadfast purpose.', 'Acts 11:22-24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, lead believers here to fast and pray before sending out missionaries. Make them sensitive to your voice as they commission workers for the harvest.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 13:1-3', 'prayer-global-porch' ),
                'verse' => _x( 'While they were worshiping the Lord and fasting, the Holy Spirit said, \'Set apart for me Barnabas and Saul for the work to which I have called them.\' Then after fasting and praying they laid their hands on them and sent them off.', 'Acts 13:1-3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, after your servants here plant churches, bring them back to strengthen and encourage the disciples. Establish elders and commit the work to your faithful care.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 14:21-28', 'prayer-global-porch' ),
                'verse' => _x( 'When they had preached the gospel to that city and had made many disciples, they returned to Lystra and to Iconium and to Antioch, strengthening the souls of the disciples...', 'Acts 14:21-28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, burden believers here to revisit and strengthen the churches they\'ve helped establish. Give them Paul\'s heart to see disciples grow strong in faith.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 15:36-41', 'prayer-global-porch' ),
                'verse' => _x( 'And after some days Paul said to Barnabas, \'Let us return and visit the brothers in every city where we proclaimed the word of the Lord, and see how they are.\'', 'Acts 15:36-41', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, add faithful young people to ministry teams here like Timothy joined Paul\'s team. Raise up the next generation to carry the gospel to unreached places.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 16:1-5', 'prayer-global-porch' ),
                'verse' => _x( 'Paul wanted Timothy to accompany him, and he took him and circumcised him because of the Jews who were in those places...', 'Acts 16:1-5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, provide couples here like Priscilla and Aquila who can instruct and equip emerging leaders. Let them open their homes to disciple those who will teach others.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 18:18-28', 'prayer-global-porch' ),
                'verse' => _x( 'Now a Jew named Apollos... came to Ephesus. He was an eloquent man, competent in the Scriptures... When Priscilla and Aquila heard him, they took him aside and explained to him the way of God more accurately.', 'Acts 18:18-28', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, help leaders here send trusted assistants ahead to prepare the way. Give them faithful co-workers like Timothy and Erastus who will represent them well.', 'prayer-global-porch' ),
                'reference' => __( 'Acts 19:22', 'prayer-global-porch' ),
                'verse' => _x( 'He sent into Macedonia two of his helpers, Timothy and Erastus, but he himself stayed in Asia for a while.', 'Acts 19:22', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, let believers here long to visit and encourage one another. Give them Paul\'s heart for mutual encouragement that strengthens everyone for the mission.', 'prayer-global-porch' ),
                'reference' => __( 'Romans 1:11-12', 'prayer-global-porch' ),
                'verse' => _x( 'For I long to see you, that I may impart to you some spiritual gift to strengthen you—that is, that we may be mutually encouraged by each other\'s faith...', 'Romans 1:11-12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, create such unity here that believers all agree with one another in Christ. Let their harmony become a powerful testimony to the truth of the gospel.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 1:10', 'prayer-global-porch' ),
                'verse' => _x( 'I appeal to you, brothers, by the name of our Lord Jesus Christ, that all of you agree, and that there be no divisions among you...', '1 Corinthians 1:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, help your servants here understand they are co-workers in your service. Let them build together on the foundation of Christ, reaching souls for your kingdom.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 3:9', 'prayer-global-porch' ),
                'verse' => _x( 'For we are God\'s fellow workers. You are God\'s field, God\'s building.', '1 Corinthians 3:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, let there be no division in the body here. Help each part care equally for the others, creating unity that enables effective witness to the lost.', 'prayer-global-porch' ),
                'reference' => __( '1 Corinthians 12:25', 'prayer-global-porch' ),
                'verse' => _x( 'That there may be no division in the body, but that the members may have the same care for one another.', '1 Corinthians 12:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, provide support here like the brothers from Macedonia supplied Paul\'s needs. Create networks of mutual care that strengthen the work of evangelism.', 'prayer-global-porch' ),
                'reference' => __( '2 Corinthians 11:9', 'prayer-global-porch' ),
                'verse' => _x( 'But when I came to Troas for the gospel of Christ... I had no rest in my spirit because I did not find my brother Titus there... But thanks be to God, who... always leads us in triumphal procession... Now when I went to Macedonia, our bodies had no rest... But God, who comforts the downcast, comforted us by the coming of Titus.', '2 Corinthians 11:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, give your servants here the right hand of fellowship like James, Peter and John gave Paul and Barnabas. Unite them in mission to the unreached.', 'prayer-global-porch' ),
                'reference' => __( 'Galatians 2:9', 'prayer-global-porch' ),
                'verse' => _x( 'So, as James and Cephas and John, who seemed to be pillars, perceived the grace that was given to me, they gave the right hand of fellowship to Barnabas and me...', 'Galatians 2:9', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, help believers here pray for all your people and for boldness in preaching. Make them faithful intercessors who support the advance of your kingdom everywhere.', 'prayer-global-porch' ),
                'reference' => __( 'Ephesians 6:18-20', 'prayer-global-porch' ),
                'verse' => _x( 'Praying at all times in the Spirit, with all prayer and supplication. To that end keep alert with all perseverance, making supplication for all the saints, and also for me...', 'Ephesians 6:18-20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, create true partnership in the gospel here like Paul had with the Philippians. Let this fellowship fuel effective outreach to the lost around them.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 1:5', 'prayer-global-porch' ),
                'verse' => _x( 'I thank my God in all my remembrance of you... because of your partnership in the gospel from the first day until now.', 'Philippians 1:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, provide faithful fellow workers here like Timothy and Epaphroditus. Send servants who truly care for the welfare of your people and your mission.', 'prayer-global-porch' ),
                'reference' => __( 'Philippians 2:19-30', 'prayer-global-porch' ),
                'verse' => _x( 'I hope in the Lord Jesus to send Timothy to you soon... For I have no one like him, who will be genuinely concerned for your welfare... But you know Timothy\'s proven worth, how as a son with a father he has served with me in the gospel.', 'Philippians 2:19-30', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, surround leaders here with faithful co-workers like those Paul mentioned from Colossae. Let each person contribute their part to reaching the unreached.', 'prayer-global-porch' ),
                'reference' => __( 'Colossians 4:7-17', 'prayer-global-porch' ),
                'verse' => _x( 'Tychicus will tell you all about my activities. He is a beloved brother and faithful minister and fellow servant in the Lord... Aristarchus my fellow prisoner greets you...', 'Colossians 4:7-17', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, help believers here acknowledge and respect those who work hard among them. Create appreciation for leaders that strengthens unity in the mission.', 'prayer-global-porch' ),
                'reference' => __( '1 Thessalonians 5:12-13', 'prayer-global-porch' ),
                'verse' => _x( 'But we ask you, brothers, to respect those who labor among you and are over you in the Lord and admonish you.', '1 Thessalonians 5:12-13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, help your people here encourage one another daily. Let their mutual support strengthen them for the hard work of reaching the lost around them.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 3:13', 'prayer-global-porch' ),
                'verse' => _x( 'But exhort one another every day, as long as it is called \'today,\' that none of you may be hardened by the deceitfulness of sin.', 'Hebrews 3:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, let believers here spur one another on toward love and good deeds. Make their community life attractive to those who have never experienced your family.', 'prayer-global-porch' ),
                'reference' => __( 'Hebrews 10:24', 'prayer-global-porch' ),
                'verse' => _x( 'And let us consider how to stir up one another to love and good works.', 'Hebrews 10:24', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, if anyone here wanders from the truth, raise up someone to bring them back. Let restoration and reconciliation mark your Church in this place.', 'prayer-global-porch' ),
                'reference' => __( 'James 5:19-20', 'prayer-global-porch' ),
                'verse' => _x( 'My brothers, if anyone among you wanders from the truth and someone brings him back, let him know that whoever brings back a sinner from his wandering will save his soul from death...', 'James 5:19-20', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, above all, help believers here love each other deeply. Let each use their gifts to serve others, creating a witness that draws the lost to faith.', 'prayer-global-porch' ),
                'reference' => __( '1 Peter 4:8-11', 'prayer-global-porch' ),
                'verse' => _x( 'Above all, keep loving one another earnestly... As each has received a gift, use it to serve one another, as good stewards of God\'s varied grace.', '1 Peter 4:8-11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, let believers here proclaim what they\'ve seen and heard so others may have fellowship with them and with you. Make them bold witnesses of your reality.', 'prayer-global-porch' ),
                'reference' => __( '1 John 1:3', 'prayer-global-porch' ),
                'verse' => _x( 'That which we have seen and heard we proclaim also to you, so that you too may have fellowship with us; and indeed our fellowship is with the Father and with his Son Jesus Christ.', '1 John 1:3', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Spirit, make believers here true companions in suffering, kingdom work, and patient endurance. Let them share John\'s commitment to faithful witness regardless of opposition.', 'prayer-global-porch' ),
                'reference' => __( 'Revelation 1:9', 'prayer-global-porch' ),
                'verse' => _x( 'I, John, your brother and partner in the tribulation and the kingdom and the patient endurance that are in Jesus...', 'Revelation 1:9', 'prayer-global-porch' ),
            ],
        ];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _i_am_statements( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {
        $section_label = __( 'I Am Statements', 'prayer-global-porch' );
        $current_templates = [
            [
                'section_label' => $section_label,
                'prayer' => __( 'Father, you declared \'I am who I am\' to Moses, revealing your eternal, unchanging nature. Draw people in this place to yourself, the God who always was and always will be. Help them find security in your faithfulness and teach others to trust in your constant presence through every season of life.', 'prayer-global-porch' ),
                'reference' => __( 'Exodus 3:14', 'prayer-global-porch' ),
                'verse' => _x( 'I AM WHO I AM.', 'Exodus 3:14', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you are the light of the world. Shine your truth into the darkness that covers this place. Open blind eyes to see your glory, and let those who walk in your light become beacons themselves, guiding others out of spiritual darkness into your light.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:12', 'prayer-global-porch' ),
                'verse' => _x( 'I am the light of the world. Whoever follows me will not walk in darkness, but will have the light of life.', 'John 8:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you are and always have been. People in this place chase after temporary things, but you are eternal. Help them grasp that you existed before creation and will remain when everything else fades. May this truth anchor their souls and compel them to live for eternal purposes.', 'prayer-global-porch' ),
                'reference' => __( 'John 8:58', 'prayer-global-porch' ),
                'verse' => _x( 'Before Abraham was, I am.', 'John 8:58', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you are the door through which your sheep enter safely. Many here are lost and seeking entrance to abundant life. Open their eyes to see you as the only way to the Father, and help them pass through you into eternal security and joy.', 'prayer-global-porch' ),
                'reference' => __( 'John 10:7', 'prayer-global-porch' ),
                'verse' => _x( 'I am the door of the sheep.', 'John 10:7', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Good Shepherd, you know your sheep. You laid down your life for them. Call the ones here who don\'t yet know your voice. Gather them into your fold. Teach them to recognize and follow your leading. Let them guide others to your safe pasture.', 'prayer-global-porch' ),
                'reference' => __( 'John 10:11', 'prayer-global-porch' ),
                'verse' => _x( 'I am the good shepherd. The good shepherd lays down his life for the sheep.', 'John 10:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you are the resurrection and the life. Death has no power over you, and neither does it have power over those who believe in you. Breathe spiritual life into the hearts of the people here who are dead in their sins, that they might live abundantly and share this life with others.', 'prayer-global-porch' ),
                'reference' => __( 'John 11:25', 'prayer-global-porch' ),
                'verse' => _x( 'I am the resurrection and the life. Whoever believes in me, though he die, yet shall he live.', 'John 11:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you are the way, the truth, and the life. Reveal yourself to the wandering people here as the only road to the Father. Let people discover that in knowing you, they possess beautiful truth and eternal life worth sharing.', 'prayer-global-porch' ),
                'reference' => __( 'John 14:6', 'prayer-global-porch' ),
                'verse' => _x( 'I am the way, and the truth, and the life. No one comes to the Father except through me.', 'John 14:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you are the true vine. Root people here in you so they may draw life from your Spirit. Prune what is dead, and cause their lives to flourish in love, obedience, and truth. Let them multiply and strengthen others.', 'prayer-global-porch' ),
                'reference' => __( 'John 15:1', 'prayer-global-porch' ),
                'verse' => _x( 'I am the true vine, and my Father is the vinedresser.', 'John 15:1', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you are the vine and we are the branches. Apart from you, these people can do nothing. Save people here from the folly of working against your will. Help them to abide in you as you abide in them, that they may bear good fruit abundantly.', 'prayer-global-porch' ),
                'reference' => __( 'John 15:5', 'prayer-global-porch' ),
                'verse' => _x( 'I am the vine; you are the branches. Whoever abides in me and I in him, he it is that bears much fruit, for apart from me you can do nothing.', 'John 15:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Alpha and Omega, you are the beginning and end of all things. Help people here understand that every story finds its meaning in you. Draw them into your eternal narrative, and use their transformed lives to bring others into your story of redemption for the nations.', 'prayer-global-porch' ),
                'reference' => __( 'Revelation 1:8', 'prayer-global-porch' ),
                'verse' => _x( 'I am the Alpha and the Omega, says the Lord God, who is and who was and who is to come, the Almighty.', 'Revelation 1:8', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Living One, you died and are alive forevermore. The people of this place need to know that death could not hold you and that same resurrection power lives in all who believe. Fill them with hope that conquers fear and compels them to share this good news.', 'prayer-global-porch' ),
                'reference' => __( 'Revelation 1:17-18', 'prayer-global-porch' ),
                'verse' => _x( 'I am the first and the last, and the living one. I died, and behold I am alive forevermore, and I have the keys of Death and Hades.', 'Revelation 1:17-18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Jesus, you are the beginning and the end. In this place where people feel their lives lack purpose or direction, reveal yourself as both their origin and destination. Help them find meaning in following you and let them teach others to walk this same purposeful path.', 'prayer-global-porch' ),
                'reference' => __( 'Revelation 21:6', 'prayer-global-porch' ),
                'verse' => _x( 'I am the Alpha and the Omega, the beginning and the end.', 'Revelation 21:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'First and Last, nothing exists outside your sovereignty. The people here may feel overwhelmed by circumstances, but you hold all things together. Give them peace in knowing you control both the beginning and end of their stories, and help them trust you completely.', 'prayer-global-porch' ),
                'reference' => __( 'Revelation 22:13', 'prayer-global-porch' ),
                'verse' => _x( 'I am the Alpha and the Omega, the first and the last, the beginning and the end.', 'Revelation 22:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Bright Morning Star, you bring the dawn of hope. Many in this place live in the darkness of despair, but you promise that weeping only lasts for a night and joy comes in the morning. Shine your light here and raise up witnesses who reflect your brightness.', 'prayer-global-porch' ),
                'reference' => __( 'Revelation 22:16', 'prayer-global-porch' ),
                'verse' => _x( 'I am the root and the descendant of David, the bright morning star.', 'Revelation 22:16', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, you hold life and death in your hands. People in this place try to find life in dead things. Show them that true life comes only from you, and help them turn from what destroys to embrace what gives abundant, eternal life worth sharing.', 'prayer-global-porch' ),
                'reference' => __( 'Deuteronomy 32:39', 'prayer-global-porch' ),
                'verse' => _x( 'See now that I, even I, am he, and there is no god beside me; I kill and I make alive; I wound and I heal; and there is none that can deliver out of my hand.', 'Deuteronomy 32:39', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you are the first and with the last throughout all generations. The people here need to know you have been faithful from the beginning and will remain faithful to the end. Strengthen their trust in your unchanging character and help them teach others about your reliability.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 41:4', 'prayer-global-porch' ),
                'verse' => _x( 'I, the LORD, the first, and with the last; I am he.', 'Isaiah 41:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, before you no god was formed, nor shall there be any after you. False gods compete for attention, reveal yourself as the one true God. Help these people abandon worthless idols and find their identity and purpose in you.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 43:10', 'prayer-global-porch' ),
                'verse' => _x( 'Before me no god was formed, nor shall there be any after me.', 'Isaiah 43:10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'People here look for salvation in many places but find only disappointment because Lord, besides you there is no savior. Open their eyes to see that you alone can rescue them from sin and death. Help them to joyfully proclaim this truth to others.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 43:11', 'prayer-global-porch' ),
                'verse' => _x( 'I, I am the LORD, and besides me there is no savior.', 'Isaiah 43:11', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, no one can deliver from your hand, and when you work, who can turn it back? Give people in this place confidence in your unstoppable purposes. Help them align their lives with your will and become part of your unstoppable kingdom work.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 43:13', 'prayer-global-porch' ),
                'verse' => _x( 'There is none who can deliver from my hand; I work, and who can turn it back?', 'Isaiah 43:13', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Holy One, you are the Creator and King. Help the people of this place to recognize your authority. Let them bow before your throne. Transform rebellious hearts into obedient ones. Help them teach others to honor you as the sovereign ruler of all.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 43:15', 'prayer-global-porch' ),
                'verse' => _x( 'I am the LORD, your Holy One, the Creator of Israel, your King.', 'Isaiah 43:15', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Guilt weighs heavily on many hearts in this place but Lord, you blot out transgressions for your own sake and remember sins no more. Help those here to experience the freedom of your complete forgiveness, and in their joy, let them extend this same grace to others around them.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 43:25', 'prayer-global-porch' ),
                'verse' => _x( 'I, I am he who blots out your transgressions for my own sake, and I will not remember your sins.', 'Isaiah 43:25', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'King of Israel, you are the first and the last, and besides you there is no God. Human leaders disappoint and fail, but you don\'t. Please reveal yourself as the perfect King whose reign never ends. Help people find strength and joy in following your perfect leadership.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 44:6', 'prayer-global-porch' ),
                'verse' => _x( 'I am the first and I am the last; besides me there is no God.', 'Isaiah 44:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, there is no other God besides you. Even those who don\'t know you are equipped by your hand. Open the eyes of people in this place to recognize your work in their lives and help them to work in accordance with your will.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 45:5', 'prayer-global-porch' ),
                'verse' => _x( 'I am the LORD, and there is no other, besides me there is no God.', 'Isaiah 45:5', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Creator God, you formed the earth to be inhabited, not empty. You have purposes for every person you made. Help everyone in this place to discover why you created them and how they fit into your grand design, that they might live with meaning and help others find their purpose too.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 45:18', 'prayer-global-porch' ),
                'verse' => _x( 'I am the LORD, and there is no other.', 'Isaiah 45:18', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lies confuse and deceive here as they do everywhere. But God, you speak truth and declare what is right. Let your truth shine clearly. Raise up people who know and speak your truth boldly, cutting through deception with the clarity of your word.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 45:19', 'prayer-global-porch' ),
                'verse' => _x( 'I the LORD speak the truth; I declare what is right.', 'Isaiah 45:19', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Righteous God and Savior, there is none besides you. The lost here may seek righteousness through their own efforts, but find only frustration. Show them that you alone are the source of righteousness. Help the joy of your salvation to produce righteousness in them.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 45:21', 'prayer-global-porch' ),
                'verse' => _x( 'There is no other god besides me, a righteous God and a Savior; there is none besides me.', 'Isaiah 45:21', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you are always the same, carrying us through every season. Those without your hope fear aging and death. Reveal yourself to them as the one who is constant when everything changes. Let them have confidence and hope in what you have in store for them.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:4', 'prayer-global-porch' ),
                'verse' => _x( 'Even to your old age I am he, and to gray hairs I will carry you. I have made, and I will bear; I will carry and will save.', 'Isaiah 46:4', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, there is no other like you, declaring the end from the beginning. When people here worry about the future, remind them that you hold all of history in your hands. Give them peace in knowing that you see the end of all things. Help them trust your perfect timing and plans.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 46:9-10', 'prayer-global-porch' ),
                'verse' => _x( 'I am God, and there is no other; I am God, and there is none like me, declaring the end from the beginning and from ancient times things not yet done.', 'Isaiah 46:9-10', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'When people in this place feel forgotten or insignificant, remind them that you are the first and the last. You are the eternal God who knows their names. Let them know that their lives are precious to you. Help them find worth in your love and share this incredible truth with those around them.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 48:12', 'prayer-global-porch' ),
                'verse' => _x( 'I am he; I am the first, and I am the last.', 'Isaiah 48:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Many in this place have been disappointed by broken promises, but your word never fails. Give them hope in your faithfulness because God, those who wait for you shall not be put to shame. Help those here to become people whose reliability reflects your own trustworthy character.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 49:23', 'prayer-global-porch' ),
                'verse' => _x( 'Then you will know that I am the LORD; those who wait for me shall not be put to shame.', 'Isaiah 49:23', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you are the one who comforts us. Fear of man troubles many hearts, but you are greater than any human threat. Fill people in this place with your peace and courage, and help them become sources of comfort and strength for others who are afraid.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 51:12', 'prayer-global-porch' ),
                'verse' => _x( 'I, I am he who comforts you.', 'Isaiah 51:12', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'God, your people shall know your name and recognize your voice. In this place where many voices compete for attention, help people learn to distinguish your voice from all others. Train their ears to hear you clearly and help them to respond in obedience.', 'prayer-global-porch' ),
                'reference' => __( 'Isaiah 52:6', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore my people shall know my name. Therefore in that day they shall know that it is I who speak; here I am.', 'Isaiah 52:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you are the God of all flesh, and nothing is too hard for you. The impossible situations in this place are not impossible for you. Increase faith here, and help people do great things for your kingdom, knowing that your power makes all things possible.', 'prayer-global-porch' ),
                'reference' => __( 'Jeremiah 32:27', 'prayer-global-porch' ),
                'verse' => _x( 'I am the LORD, the God of all flesh. Is anything too hard for me?', 'Jeremiah 32:27', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Unchanging Lord, because you do not change, your people are not consumed. When anything else here changes, you remain constant. Help people find stability and a foundation in your unchanging nature. Help them become reliable witnesses to your faithfulness.', 'prayer-global-porch' ),
                'reference' => __( 'Malachi 3:6', 'prayer-global-porch' ),
                'verse' => _x( 'For I the LORD do not change; therefore you, O children of Jacob, are not consumed.', 'Malachi 3:6', 'prayer-global-porch' ),
            ],
            [
                'section_label' => $section_label,
                'prayer' => __( 'Lord, you are the bread of life. People in this place are starving spiritually. Please make the lost aware of their need, and help them to come to you for sustenance. Please fill, strengthen, and renew them with your life. In their joy, let them tell their hungry friends and family members where they found bread.', 'prayer-global-porch' ),
                'reference' => __( 'John 6:35', 'prayer-global-porch' ),
                'verse' => _x( 'I am the bread of life; whoever comes to me shall not hunger, and whoever believes in me shall never thirst.', 'John 6:35', 'prayer-global-porch' ),
            ],
        ];

        $ai_templates = [];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    public static function _cities( &$lists, $stack, $all = false, $include_ai = false, $include_current = true ) {

        if ( empty( $stack['location']['cities_list_w_pop'] ) ) {
            return $lists;
        }
        $current_templates = [
            [
                'section_label' => sprintf( __( 'Cities in %s', 'prayer-global-porch' ), $stack['location']['name'] ),
                'prayer' => sprintf( __( 'Jesus, bring your gospel to the people living in %1$s.', 'prayer-global-porch' ), $stack['location']['cities_list'] ),
                'reference' => __( 'Matthew 28:19-20a', 'prayer-global-porch' ),
                'verse' => _x( 'Therefore go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit, and teaching them to obey everything I have commanded you.', 'Matthew 28:19-20a', 'prayer-global-porch' ),
            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
//            [
//                'section_label' => $section_label,
//                'prayer' => '',
//                'reference' => '',
//                'verse' => '',
//            ],
        ];

        $ai_templates = [];

        $templates = [];
        if ( $include_ai ) {
            $templates = array_merge( $templates, $ai_templates );
        }
        if ( $include_current ) {
            $templates = array_merge( $templates, $current_templates );
        }
        if ( $all ) {
            $lists = array_merge( $templates, $lists );
            return $lists;
        }

        $lists = array_merge( [ $templates[array_rand( $templates ) ] ], $lists );
        return $lists;
    }

    /* Illustration based blocks */
    public static function least_reached_text( $stack ): array
    {
        /**
         * Least Reached Block
         */
        return [
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Lord we ask you on behalf of the %1$s people. %2$s%% are known to be believers. Oh God, please share with them the great gift of your son Jesus and your kingdom.', 'prayer-global-porch' ), $stack['least_reached']['name'], number_format( (float) $stack['least_reached']['PercentEvangelical'], 1 ) ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Lord, please remember the %1$s people. you said you wanted worshippers of every tongue and tribe and nation, yet we know of no worshippers among them.', 'prayer-global-porch' ), $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Lord, you sent Jesus as a witness to testify about the light so that all the %1$s people might believe through him.', 'prayer-global-porch' ), $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Lord, bring the blind by a way that they don’t know. Lead the %1$s people in paths that they don’t know. Make darkness light before them and crooked places straight. Do not forsake the %2$s people.', 'prayer-global-porch' ), $stack['least_reached']['name'], $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Lord, I thank you that you will bring health and a cure to the %1$s people. Reveal to them abundance of peace and truth.', 'prayer-global-porch' ), $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Father, open to your people a door for the word, to speak the mystery of Christ to the %1$s people.', 'prayer-global-porch' ), $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Father, I pray against the principalities, against the powers, against the world’s rulers of darkness of this age, and against the spiritual forces of the wickedness in the heavenly places that are warring against the %1$s people.', 'prayer-global-porch' ), $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Jesus, I pray that all the %1$s people will remember and turn to you, Lord God. May all the %2$s people worship before you. For the kingdom of the %3$s people is yours.', 'prayer-global-porch' ), $stack['least_reached']['name'], $stack['least_reached']['name'], $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Lord God, I thank you that the blood of Christ, who through the eternal Spirit offered himself without defect to God, can cleanse the %1$s people conscience from dead works to serve the living God.', 'prayer-global-porch' ), $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Spirit, I pray that the %1$s people will come and worship before you, Lord. May they glorify your name for you are great.', 'prayer-global-porch' ), $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Lord, Let your Kingdom come among the %1$s people. Let your will be done, as in heaven, so on earth.', 'prayer-global-porch' ), $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Lord, remember the %1$s people. Make the %2$s people a chosen race, a royal priesthood, a holy nation, a people for your own possession.', 'prayer-global-porch' ), $stack['least_reached']['name'], $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Father, I pray that the %1$s people will not be afraid or ashamed. Prevent them from being confounded or disappointed in their search for you. May the %2$s people know you.', 'prayer-global-porch' ), $stack['least_reached']['name'], $stack['least_reached']['name'] ),
            ],
            [
                'section_summary' => '',
                'prayer' => sprintf( __( 'Father, %1$s%% are known to be believers. Please, Lord call more today.', 'prayer-global-porch' ), number_format( (float) $stack['least_reached']['PercentEvangelical'], 1 ) ),
            ],
        ];
    }

    public static function photos_text( $stack ): array
    {
        /**
         * Photos Block
         */
        return [
            [
                'section_summary' => __( 'What people or activities could you pray for in this photo?', 'prayer-global-porch' ),
                'prayer' => '',
            ],
            [
                'section_summary' => __( 'What people or resources could you pray for in this photo?', 'prayer-global-porch' ),
                'prayer' => '',
            ],
            [
                'section_summary' => __( 'What needs would people have here?', 'prayer-global-porch' ),
                'prayer' => '',
            ],
            [
                'section_summary' => __( 'What blessing is needed here?', 'prayer-global-porch' ),
                'prayer' => '',
            ],
            [
                'section_summary' => __( 'What conditions of religion or environment could you pray for here?', 'prayer-global-porch' ),
                'prayer' => '',
            ],
            [
                'section_summary' => __( 'What challenges do people here face?', 'prayer-global-porch' ),
                'prayer' => '',
            ],
            [
                'section_summary' => __( 'What beauty can God be thanked for in this photo?', 'prayer-global-porch' ),
                'prayer' => '',
            ],
        ];
    }

    public static function key_city_text( $stack, $key_city ): array
    {
        /**
         * Key City Block
         */
        return [
            [
                'section_summary' => sprintf( __( 'Pray that God raises up new churches in the city of %s.', 'prayer-global-porch' ), $key_city['full_name'] ),
            ],
        ];
    }

    public static function cities_text( $stack ): array
    {
        /**
         * Key City Block
         */
        return [
            [
                'prayer' => sprintf( __( 'Pray that God encourage his people in all these cities.', 'prayer-global-porch' ) ),
            ],
            [
                'prayer' => sprintf( __( 'Pray that new churches are planted in these cities.', 'prayer-global-porch' ) ),
            ],
        ];
    }

    public static function demographics_content_text( $stack ): array
    {

        return [
            /**
             * PRAYERS TARGETING BELIEVERS
             */
            'believers' => [
                [
                    'section_summary' => sprintf( _x( '%1$s of %2$s has a population of %3$s.', 'The state of Colorado has a population of 5,773,714.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], '<strong>'.$stack['location']['full_name'].'</strong>', '<strong>'.$stack['location']['population'].'</strong>' ).
                        '<br><br>'.
                        sprintf( _x( 'We estimate %1$s has %2$s people who might know Jesus, %3$s people who might know about Jesus culturally, and %4$s people who do not know Jesus.', 'We estimate new york has 100 people who might know Jesus, 300 people who might know about Jesus culturally, and 500 people who do not know Jesus.', 'prayer-global-porch' ), $stack['location']['name'], '<strong>'.$stack['location']['believers'].'</strong>', '<strong>'.$stack['location']['christian_adherents'].'</strong>', '<strong>'.$stack['location']['non_christians'].'</strong>' ).
                        '<br><br>'.
                        sprintf( __( 'This is %1$s believer for every %2$s neighbors who need Jesus.', 'prayer-global-porch' ), '<strong>1</strong>', '<strong>'.$stack['location']['lost_per_believer'].'</strong>' ),
                ],
            ],
            /**
             * PRAYERS TARGETING CULTURAL CHRISTIANS
             */
            'christian_adherents' => [
                [
                    'section_summary' => sprintf( _x( '%1$s of %2$s has a population of %3$s.', 'The state of Colorado has a population of 5,773,714.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], '<strong>'.$stack['location']['full_name'].'</strong>', '<strong>'.$stack['location']['population'].'</strong>' ).
                        '<br><br>'.
                        sprintf( _x( 'We estimate %1$s has %2$s people who might know Jesus, %3$s people who might know about Jesus culturally, and %4$s people who do not know Jesus.', 'We estimate new york has 100 people who might know Jesus, 300 people who might know about Jesus culturally, and 500 people who do not know Jesus.', 'prayer-global-porch' ), $stack['location']['name'], '<strong>'.$stack['location']['believers'].'</strong>', '<strong>'.$stack['location']['christian_adherents'].'</strong>', '<strong>'.$stack['location']['non_christians'].'</strong>' ).
                        '<br><br>'.
                        sprintf( __( 'This is %1$s believer for every %2$s neighbors who need Jesus.', 'prayer-global-porch' ), '<strong>1</strong>', '<strong>'.$stack['location']['lost_per_believer'].'</strong>' ),
                ],
            ],
            /**
             * PRAYERS TARGETING NON CHRISTIANS
             */
            'non_christians' => [
                [
                    'section_summary' => sprintf( _x( '%1$s of %2$s has a population of %3$s.', 'The state of Colorado has a population of 5,773,714.', 'prayer-global-porch' ), $stack['location']['admin_level_title'], '<strong>'.$stack['location']['full_name'].'</strong>', '<strong>'.$stack['location']['population'].'</strong>' ).
                        '<br><br>'.
                        sprintf( _x( 'We estimate %1$s has %2$s people who might know Jesus, %3$s people who might know about Jesus culturally, and %4$s people who do not know Jesus.', 'We estimate new york has 100 people who might know Jesus, 300 people who might know about Jesus culturally, and 500 people who do not know Jesus.', 'prayer-global-porch' ), $stack['location']['name'], '<strong>'.$stack['location']['believers'].'</strong>', '<strong>'.$stack['location']['christian_adherents'].'</strong>', '<strong>'.$stack['location']['non_christians'].'</strong>' ).
                        '<br><br>'.
                        sprintf( __( 'This is %1$s believer for every %2$s neighbors who need Jesus.', 'prayer-global-porch' ), '<strong>1</strong>', '<strong>'.$stack['location']['lost_per_believer'].'</strong>' ),
                ],
            ]
        ];
    }

    public static function demogrphics_4_fact_text( $stack ): array
    {

        return [
            /**
             * PRAYERS TARGETING BELIEVERS
             */
            'believers' => [
                [
                    'prayer' => '',
                ],
            ],
            /**
             * PRAYERS TARGETING CULTURAL CHRISTIANS
             */
            'christian_adherents' => [
                [
                    'prayer' => '',
                ],
            ],
            /**
             * PRAYERS TARGETING NON CHRISTIANS
             */
            'non_christians' => [
                [
                    'prayer' => '',
                ],
            ]
        ];
    }
}


/**
 * (
[location] => Array
        (
        [grid_id] => 100219785
        [name] => Saiha
        [admin0_name] => India
        [full_name] => Saiha, Mizoram, India
        [population] => 22,700
        [latitude] => 22.3794
        [longitude] => 93.0146
        [country_code] => IN
        [admin0_code] => IND
        [parent_id] => 100219370
        [parent_name] => Mizoram
        [admin0_grid_id] => 100219347
        [admin1_grid_id] => 100219370
        [admin1_name] => Mizoram
        [admin2_grid_id] => 100219785
        [admin2_name] => Saiha
        [admin3_grid_id] =>
        [admin3_name] =>
        [admin4_grid_id] =>
        [admin4_name] =>
        [admin5_grid_id] =>
        [admin5_name] =>
        [level] => 2
        [level_name] => admin2
        [north_latitude] => 22.8106
        [south_latitude] => 21.9462
        [east_longitude] => 93.2093
        [west_longitude] => 92.827
        [p_longitude] => 92.8362
        [p_latitude] => 23.3068
        [p_north_latitude] => 24.5208
        [p_south_latitude] => 21.9462
        [p_east_longitude] => 93.4447
        [p_west_longitude] => 92.2594
        [c_longitude] => 82.8007
        [c_latitude] => 21.1278
        [c_north_latitude] => 35.5013
        [c_south_latitude] => 6.75426
        [c_east_longitude] => 97.4152
        [c_west_longitude] => 68.1862
        [peer_locations] => 8
        [birth_rate] => 18.7
        [death_rate] => 7.2
        [growth_rate] => 1.115
        [believers] => 250
        [christian_adherents] => 275
        [non_christians] => 22,175
        [primary_language] => Hindi
        [primary_religion] => Hinduism
        [percent_believers] => 1.1
        [percent_christian_adherents] => 1.21
        [percent_non_christians] => 97.69
        [admin_level_title] => county
        [admin_level_title_plural] => counties
        [population_int] => 22700
        [believers_int] => 250
        [christian_adherents_int] => 275
        [non_christians_int] => 22175
        [percent_believers_full] => 1.1
        [percent_christian_adherents_full] => 1.21333
        [percent_non_christians_full] => 97.6867
        [all_lost_int] => 22450
        [all_lost] => 22,450
        [lost_per_believer_int] => 90
        [lost_per_believer] => 90
        [population_growth_status] => Significant Growth
        [deaths_non_christians_next_hour] => 0
        [deaths_non_christians_next_100] => 1
        [deaths_non_christians_next_week] => 3
        [deaths_non_christians_next_month] => 13
        [deaths_non_christians_next_year] => 161
        [births_non_christians_last_hour] => 0
        [births_non_christians_last_100] => 4
        [births_non_christians_last_week] => 8
        [births_non_christians_last_month] => 34
        [births_non_christians_last_year] => 419
        [deaths_christian_adherents_next_hour] => 0
        [deaths_christian_adherents_next_100] => 0
        [deaths_christian_adherents_next_week] => 0
        [deaths_christian_adherents_next_month] => 0
        [deaths_christian_adherents_next_year] => 1
        [births_christian_adherents_last_hour] => 0
        [births_christian_adherents_last_100] => 0
        [births_christian_adherents_last_week] => 0
        [births_christian_adherents_last_month] => 0
        [births_christian_adherents_last_year] => 5
        [favor] => non_christians
        [icon_color] => orange
)

[cities] => Array
(
    [0] => Array
        (
            [id] => 28641
            [geonameid] => 1257771
            [name] => Saiha
            [full_name] => Saiha, Mizoram, India
            [admin0_name] => India
            [latitude] => 22.4918
            [longitude] => 92.9814
            [timezone] => Asia/Kolkata
            [population_int] => 22654
            [population] => 22,654
        )

    )

[people_groups] => Array
(
    [1] => Array
    (
        [id] => 6301
        [name] => Halam Rupini
        [longitude] => 92.7058
        [latitude] => 23.724
        [lg_name] => Aizawl
        [lg_full_name] => Aizawl, Aizawl, Mizoram, India
        [admin0_name] => India
        [admin0_grid_id] => 100219347
        [admin1_grid_id] => 100219370
        [admin2_grid_id] => 100219779
        [admin3_grid_id] => 100221497
        [admin4_grid_id] =>
        [admin5_grid_id] =>
        [population] => 4,500
        [JPScale] => 2
        [LeastReached] => N
        [PrimaryLanguageName] => Kok Borok
        [PrimaryReligion] => Hinduism
        [PercentAdherents] => 44.854
        [PercentEvangelical] => 0
        [PeopleCluster] => South Asia Tribal - other
        [AffinityBloc] => South Asian Peoples
        [PeopleID3] => 19763
        [ROP3] => 115791
        [ROG3] => IN
        [pg_unique_key] => IN_19763_115791
        [query_level] => parent
    )

)

[least_reached] => Array
    (
        [id] => 5939
        [name] => Chakma
        [longitude] => 92.7688
        [latitude] => 23.7962
        [lg_name] => Aizawl
        [lg_full_name] => Aizawl, Aizawl, Mizoram, India
        [admin0_name] => India
        [admin0_grid_id] => 100219347
        [admin1_grid_id] => 100219370
        [admin2_grid_id] => 100219779
        [admin3_grid_id] => 100221497
        [admin4_grid_id] =>
        [admin5_grid_id] =>
        [population] => 217,000
        [JPScale] => 1
        [LeastReached] => Y
        [PrimaryLanguageName] => Chakma
        [PrimaryReligion] => Buddhism
        [PercentAdherents] => 4.914
        [PercentEvangelical] => 0
        [PeopleCluster] => South Asia Tribal - other
        [AffinityBloc] => South Asian Peoples
        [PeopleID3] => 11293
        [ROP3] => 101976
        [ROG3] => IN
        [pg_unique_key] => IN_11293_101976
        [query_level] => parent
    )

)
 */
