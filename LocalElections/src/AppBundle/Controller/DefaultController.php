<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Postcode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request)
    {
        $postcode = new Postcode();
        $form = $this->createForm('AppBundle\Form\PostcodeHomepageType', $postcode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $postcode->sanitizePostcode();
            $postcode = $this
                ->getDoctrine()
                ->getRepository('AppBundle:Postcode')
                ->findOneBy(['postcode' => $postcode->getPostcode()])
            ;
            if (!$postcode) {
                return $this->render(':default:homepage.html.twig', [
                    'form' => $form->createView(),
                    'msg' => 'Nie znaleziono podanego kodu.',
                ]);
            } else {
                return $this->redirectToRoute('results', ['code' => $postcode->getPostcode()]);
            }
        }

        return $this->render(':default:homepage.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return array
     *
     * @Route("/adm", name="admin")
     * @Template(":default:admin.html.twig")
     */
    public function adminPanelAction()
    {
        return [];
    }

    /**
     * @param string $code
     * @return array
     *
     * @Route("/{code}", name="results", requirements={"code" = "\d+"})
     * @Template(":default:results.html.twig")
     */
    public function resultsAction($code)
    {
        $postcode = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Postcode')
            ->findOneBy(['postcode' => $code])
        ;
        if (!$postcode) {
            throw $this->createNotFoundException('Nie znaleziono kodu pocztowego: ' . $code);
        }
        $codeStr = substr($code, 0, 2) . '-' . substr($code, 2);
        $wards = $postcode->getWards();
        if (!count($wards)) {
            return [
                'postcode' => $codeStr,
                'msg' => 'Nie znaleziono obwodów głosowania.',
            ];
        } else {
            return [
                'postcode' => $codeStr,
                'wards' => $wards,
            ];
        }
    }

    /**
     * @param int $districtId
     * @return array
     *
     * @Route("listy/{districtId}", name="candidates")
     * @Template(":default:candidates.html.twig")
     */
    public function showCandidatesAction($districtId)
    {
        $district = $this
            ->getDoctrine()
            ->getRepository('AppBundle:District')
            ->find($districtId)
        ;
        if (!$district) {
            throw $this->createNotFoundException('Nie znaleziono okręgu. id=' . $districtId);
        }
        return ['district' => $district];
    }
}
