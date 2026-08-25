<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [

            // ═════════════════════════════════════════════════════════════════
            // HOMEPAGE ('home')
            // ═════════════════════════════════════════════════════════════════
            'home' => [
                'hero' => [
                    'title'    => 'Viver bem em Luanda <br/> é uma escolha.',
                    'subtitle' => 'Mais de 200 imóveis premium em Luanda com o acompanhamento que merece',
                    'image'    => '1.jpeg',
                ],
                'categories' => [
                    'tag'   => 'TIPOS DE PROPRIEDADES',
                    'title' => 'Encontre o seu lugar em Luanda',
                ],
                'featured' => [
                    'tag'   => 'Propriedades',
                    'title' => 'Imóveis em Destaque',
                    'button_text' => 'Ver Mais',
                ],
                'services' => [
                    'tag'   => 'Sobre',
                    'title' => 'O que nós fazemos',
                    'srv_1_title' => 'Parceria com proprietários',
                    'srv_1_desc'  => 'Cuidamos do seu imóvel como se fosse nosso. Manutenção, ocupação e valorização contínua, com total tranquilidade para o proprietário.',
                    'srv_2_title' => 'Avaliação Imobiliária',
                    'srv_2_desc'  => 'Encontramos o imóvel certo para si, ou o comprador/inquilino certo para o seu imóvel, com acompanhamento em cada etapa.',
                    'srv_3_title' => 'Consultoria para investidores',
                    'srv_3_desc'  => 'Apoio especializado para quem quer investir com segurança no mercado imobiliário angolano.',
                    'srv_4_title' => 'Gestão de património',
                    'srv_4_desc'  => 'Identificamos oportunidades com elevado potencial de valorização para quem quer investir em Angola.',
                ],
                'international' => [
                    'tag'   => 'Propriedades',
                    'title' => 'Imóveis Internacionais em Destaque',
                    'button_text' => 'Ver Mais',
                ],
                'cta' => [
                    'title'         => 'Encontre o imóvel ideal para si',
                    'subtitle'      => 'Descubra oportunidades exclusivas de compra, venda e arrendamento em Luanda e nas principais cidades de Angola.',
                    'button_text'   => 'Ver Imóveis',
                    'button_url'    => '/imoveis',
                    'button_target' => '_self',
                    'bg_color'      => '#F97316',
                ],
            ],

            // ═════════════════════════════════════════════════════════════════
            // SOBRE NÓS ('about')
            // ═════════════════════════════════════════════════════════════════
            'about' => [
                'hero' => [
                    'title' => 'Há mais de uma década e meia, ajudamos pessoas, empresas e instituições a escolher Angola — e a escolher bem.',
                    'image' => 'Executives_overlooking_Luanda_sk…_202607031225.jpeg',
                ],
                'history' => [
                    'label'        => 'A Nossa História',
                    'title'        => 'Evolução, Padrão e Compromisso.',
                    'text_1'       => 'A Time To Choose nasceu de uma convicção simples: o mercado imobiliário angolano merecia mais. Mais rigor. Mais padrão. Mais serviço.',
                    'text_2'       => 'Com 30 anos de experiência internacional e mais de 15 anos dedicados exclusivamente a Angola, construímos um legado baseado na confiança e na exclusividade. Não somos apenas mediadores; somos consultores estratégicos no coração de Luanda.',
                    'stat_1_num'   => '30+',
                    'stat_1_label' => 'Anos Globais',
                    'stat_2_num'   => '15+',
                    'stat_2_label' => 'Anos em Angola',
                    'image'        => 'Real_estate_consultant_welcoming…_202607030647.jpeg',
                ],
                'numbers' => [
                    'stat_1_num'   => '+15',
                    'stat_1_label' => 'Anos no Mercado',
                    'stat_2_num'   => '+30',
                    'stat_2_label' => 'Profissionais',
                    'stat_3_num'   => '+200',
                    'stat_3_label' => 'Imóveis Ativos',
                    'stat_4_num'   => '50+',
                    'stat_4_label' => 'Clientes Globais',
                ],
                'cta' => [
                    'title'       => 'Pronto para encontrar o seu imóvel ideal?',
                    'subtitle'    => 'Fale com a nossa equipa e descubra as melhores oportunidades do mercado angolano.',
                    'button_text' => 'Ver Imóveis',
                ],
            ],

            // ═════════════════════════════════════════════════════════════════
            // INVESTIDORES ('investors')
            // ═════════════════════════════════════════════════════════════════
            'investors' => [
                'hero' => [
                    'title'       => 'Soluções de investimento imobiliário com retorno estruturado em Angola',
                    'subtitle'    => 'Criamos soluções completas para investidores que pretendem entrar ou expandir no mercado imobiliário angolano com segurança, rentabilidade e gestão profissional. Atuamos como seu parceiro local.',
                    'button_text' => 'Falar com um Consultor',
                    'image'       => 'Real_estate_consultant_presentin…_202607021733.jpeg',
                ],
                'opportunity' => [
                    'title'        => 'Porquê Luanda Agora?',
                    'text_1'       => 'O crescimento acelerado de Luanda, impulsionado por novos polos de desenvolvimento económico, gera uma demanda constante por habitação de alto padrão.',
                    'text_2'       => 'Existe atualmente um défice significativo de oferta qualificada, especialmente para o segmento expatriado e corporate housing, onde a rentabilidade é dolarizada e as yields são superiores à média regional.',
                    'stat_1_num'   => '12%+',
                    'stat_1_label' => 'Yield Anual Média',
                    'stat_2_num'   => 'Alto',
                    'stat_2_label' => 'Capital Appreciation',
                    'image'        => 'An_ultra-realistic_luxury_real_estate_202607021617.jpeg',
                ],
                'services' => [
                    'title'    => 'Serviços 360º para Investidores',
                    'subtitle' => 'Um ecossistema completo para gerir o seu património sem preocupações operacionais.',
                ],
                'performance' => [
                    'title'    => 'Performance Financeira',
                    'subtitle' => 'Utilize o nosso simulador para projetar os retornos baseados em dados reais do mercado de Luanda (Talatona, Marginal e Kilamba).',
                    'roi'      => '15% - 22% p.a.',
                    'payback'  => '6.5 Anos',
                ],
            ],

            // ═════════════════════════════════════════════════════════════════
            // AVALIAÇÃO IMOBILIÁRIA ('valuation')
            // ═════════════════════════════════════════════════════════════════
            'valuation' => [
                'hero' => [
                    'title'       => 'Avaliação Imobiliária',
                    'subtitle'    => 'Determine o valor real de mercado do seu património em Angola. Combinamos análise técnica rigorosa com inteligência estratégica de mercado.',
                    'button_text' => 'Solicitar Avaliação',
                    'image'       => 'Real_estate_valuation_report_pre…_202607021706.jpeg',
                ],
                'methodology' => [
                    'title'    => 'Nossa Metodologia',
                    'subtitle' => 'Utilizamos um processo estruturado e analítico para garantir que o valor apurado reflete a realidade económica e as particularidades de cada imóvel.',
                ],
                'objectives' => [
                    'title'    => 'Objectivos da Avaliação',
                    'subtitle' => 'Entenda como o nosso relatório se torna uma ferramenta de poder na sua mão.',
                ],
                'modalities' => [
                    'title' => 'Modalidades de Serviço',
                ],
            ],

            // ═════════════════════════════════════════════════════════════════
            // GESTÃO DE PROPRIEDADES ('management')
            // ═════════════════════════════════════════════════════════════════
            'management' => [
                'hero' => [
                    'title'       => 'Gestão de Património',
                    'subtitle'    => 'A Time To Choose assume a gestão completa dos seus imóveis, focando em rentabilidade, conservação, ocupação e tranquilidade total para o proprietário.',
                    'button_text' => 'Solicitar Gestão',
                    'image'       => 'Property_manager_discussing_perf…_202607021718.jpeg',
                ],
                'services' => [
                    'title'    => 'O Que Fazemos',
                    'subtitle' => 'Gestão integral para maximizar o seu retorno e proteger o seu investimento.',
                ],
                'fullpack' => [
                    'title'    => 'Modelo Full-Pack & Foco Corporate',
                    'subtitle' => 'Integramos serviços para oferecer uma experiência sem atritos, com forte orientação para o mercado corporativo, incluindo diplomatas e expatriados, garantindo arrendatários de alta fiabilidade.',
                    'image'    => 'Real_estate_consultant_welcoming…_202607030647.jpeg',
                ],
            ],

            // ═════════════════════════════════════════════════════════════════
            // PROPRIEDADES & PARCEIROS ('partners')
            // ═════════════════════════════════════════════════════════════════
            'partners' => [
                'hero' => [
                    'title'        => 'O seu imóvel merece uma gestão profissional.',
                    'subtitle'     => 'Na Time To Choose, valorizamos relações sólidas e duradouras com proprietários e parceiros, baseadas em transparência, confiança e resultados. Trabalhamos lado a lado com cada cliente para transformar imóveis em activos rentáveis, assegurando uma gestão profissional e uma ocupação eficiente.',
                    'button_text'  => 'Agendar Reunião',
                    'card_1_title' => 'Gestão de Arrendamento',
                    'card_1_desc'  => 'Gerimos o seu imóvel e tratamos de todo o processo de arrendamento.',
                    'card_2_title' => 'Full-Pack Residencial',
                    'card_2_desc'  => 'Transformamos o imóvel num produto premium com serviços integrados, aumentando o valor e a procura.',
                    'image'        => 'An_ultra-realistic_luxury_real_estate_202607021617.jpeg',
                ],
                'value' => [
                    'title'    => 'A Nossa Proposta de Valor',
                    'subtitle' => 'Três pilares fundamentais para garantir o sucesso do seu investimento imobiliário.',
                ],
                'models' => [
                    'title'    => 'Modelos de Parceria',
                    'subtitle' => 'Soluções adaptadas aos seus objetivos de investimento.',
                ],
                'howworks' => [
                    'title'    => 'Como Funciona',
                    'subtitle' => 'Um processo simples e transparente em 4 passos.',
                ],
                'fullpack' => [
                    'title'    => 'Benefícios que transformam o seu imóvel numa experiência premium.',
                    'subtitle' => 'Transformamos propriedades comuns em experiências habitacionais exclusivas, aumentando o valor do seu património através de uma gestão integrada, serviços premium e elevados padrões de qualidade.',
                ],
            ],
        ];

        foreach ($sections as $page => $pageSections) {
            foreach ($pageSections as $section => $fields) {
                foreach ($fields as $field => $value) {
                    PageSection::updateOrCreate(
                        [
                            'page'    => $page,
                            'section' => $section,
                            'field'   => $field,
                        ],
                        [
                            'value'   => $value,
                        ]
                    );
                }
            }
        }
    }
}
