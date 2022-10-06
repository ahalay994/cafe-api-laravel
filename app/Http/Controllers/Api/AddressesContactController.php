<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\AddressesContact\AddressesContactResponseData;
use App\DataTransferObjects\AddressesContact\AddressesContactsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressesContactRequest;
use App\Models\AddressesContact;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressesContactController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $addressesContacts = AddressesContact::paginate();

        return new ResponsePaginationData([
            'paginator' => $addressesContacts,
            'collection' => new AddressesContactsCollection(['collection' => $addressesContacts->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return AddressesContactResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): AddressesContactResponseData|NotFoundHttpException
    {
        try {
            $addressesContact = AddressesContact::findOrFail($id);

            return new AddressesContactResponseData(['addressesContact' => $addressesContact, 'message' => __('controller.addressesContact.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param AddressesContactRequest $request
     * @return AddressesContactResponseData
     * @throws UnknownProperties
     */
    public function create(AddressesContactRequest $request): AddressesContactResponseData
    {
        $addressesContact = AddressesContact::create($request->all());

        return new AddressesContactResponseData(['addressesContact' => $addressesContact, 'message' => __('controller.addressesContact.create')]);
    }

    /**
     * @param AddressesContactRequest $request
     * @param int $id
     * @return AddressesContactResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(AddressesContactRequest $request, int $id): AddressesContactResponseData|NotFoundHttpException
    {
        try {
            $addressesContact = AddressesContact::findOrFail($id);
            $addressesContact->address_id = $request->address_id ?? $addressesContact->address_id;
            $addressesContact->type = $request->type ?? $addressesContact->type;
            $addressesContact->value = $request->value ?? $addressesContact->value;
            $addressesContact->description = $request->description ?? $addressesContact->description;
            $addressesContact->save();

            return new AddressesContactResponseData(['addressesContact' => $addressesContact, 'message' => __('controller.addressesContact.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|NotFoundHttpException
     */
    public function delete(int $id): JsonResponse|NotFoundHttpException
    {
        try {
            AddressesContact::destroy($id);

            return $this->responseSuccess(__('controller.addressesContact.delete', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|NotFoundHttpException
     */
    public function restore(int $id): JsonResponse|NotFoundHttpException
    {
        try {
            AddressesContact::onlyTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess(__('controller.addressesContact.restore', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
